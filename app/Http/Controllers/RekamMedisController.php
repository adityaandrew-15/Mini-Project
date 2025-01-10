<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Resep;
use App\Models\Obat;
use App\Models\Peralatan;
use App\Models\RekamMedisImage;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Storage;


class RekamMedisController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $rekamMedis = [];

    if ($user->hasRole('dokter')) {
        // Get only the medical records for the logged-in doctor
        $rekamMedis = RekamMedis::whereHas('kunjungan', function($query) use ($user) {
            $query->where('dokter_id', $user->id);
        })->with(['resep', 'obats'])->paginate(10);
    } elseif ($user->hasRole('admin')) {
        $rekamMedis = RekamMedis::with(['resep', 'obats'])->paginate(10);
    }

    // Get kunjungan data for the logged-in doctor
    if($user->hasRole('admin')){
        $knjgn = Kunjungan::all();
    }elseif($user->hasRole('dokter')){
        $knjgn = Kunjungan::where('dokter_id', optional($user->dokter)->id)
                  ->where('status', 'UNDONE')
                  ->get();
    }
    $obats = Obat::all();
    $peralatans = Peralatan::all();


    return view('rekam_medis.index', compact('rekamMedis', 'knjgn', 'obats', 'peralatans',));
}
public function create()
{
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        // Admin can see all patients
        $kunjungans = Kunjungan::with('pasien')->get();
    } else {
        // Doctor can only see their associated p   atients
        $kunjungans = Kunjungan::where('dokter_id', $user->id)->with('pasien')->get();
    }

    return view('rekam_medis.create', compact('kunjungans'));
}
public function store(Request $request)
{
    $validated = $request->validate([
        'kunjungan_id' => 'required|exists:kunjungans,id',
        'diagnosa' => 'required',
        'tindakan' => 'required',
        'deskripsi' => 'required|string',
        'obat_id.*' => 'exists:obats,id',
        'jumlah_obat.*' => 'required|integer|min:1',
        'peralatan_id.*' => 'exists:peralatans,id',
    ]);

    // Cek apakah kunjungan yang dipilih adalah milik dokter yang sedang login
    $kunjungan = Kunjungan::findOrFail($validated['kunjungan_id']);
    if ($kunjungan->dokter_id !== auth()->id()) {
        return back()->with('error', 'Anda tidak memiliki izin untuk menginput rekam medis untuk pasien ini.');
    }

    $rekamMedis = RekamMedis::create([
        'kunjungan_id' => $validated['kunjungan_id'],
        'pasien_id' => $kunjungan->pasien_id, // Menambahkan pasien_id
        'diagnosa' => $validated['diagnosa'],
        'tindakan' => $validated['tindakan'],
    ]);

    // Simpan data resep
    Resep::create([
        'kunjungan_id' => $validated['kunjungan_id'],
        'rekam_medis_id' => $rekamMedis->id,
        'deskripsi' => $validated['deskripsi'],
    ]);

    // Simpan gambar jika ada
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('rekam_medis', 'public');
            $rekamMedis->images()->create(['image_path' => $path]);
        }
    }

    foreach ($validated['obat_id'] as $index => $obatId) {
        $obat = Obat::findOrFail($obatId);
        $jumlah = $validated['jumlah_obat'][$index];

        if ($obat->jumlah >= $jumlah) {
            $obat->decrement('jumlah', $jumlah); // Kurangi stok obat
            $rekamMedis->obats()->attach($obat->id, ['jumlah' => $jumlah]); // Simpan ke pivot table
        } else {
            return back()->with('error', 'Stok obat tidak mencukupi untuk ' . $obat->obat);
        }
    }

    $kunjungan->status = 'DONE';
    $kunjungan->save();

    // Hubungkan peralatan
    if (!empty($validated['peralatan_id'])) {
        $rekamMedis->peralatans()->sync($validated['peralatan_id']);
    }

    return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil ditambahkan.');
}



public function edit(RekamMedis $rekamMedis)
{
    $user = auth()->user();
    // Get only the kunjungans associated with the logged-in doctor
    $kunjungans = Kunjungan::where('dokter_id', $user->id)->with('pasien')->get();
    return view('rekam_medis.edit', compact('rekamMedis', 'kunjungans'));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'diagnosa' => 'required|string|max:255',
        'tindakan' => 'required|string|max:255',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'deskripsi' => 'required|string',
        'obat_id.*' => 'required|exists:obats,id',
        'jumlah_obat.*' => 'required|integer|min:1',
        'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'peralatan_id.*' => 'exists:peralatans,id',
    ]);


    $rekamMedis = RekamMedis::findOrFail($id);

    // Handle image deletion if any
    if ($request->has('delete_images') && is_array($request->delete_images)) {
        foreach ($request->delete_images as $imageId) {
            $image = RekamMedisImage::find($imageId);
            if ($image) {
                // Delete image file and database record
                Storage::delete('public/' . $image->image_path);
                $image->delete();
            }
        }
    }

    // Update Rekam Medis data
    $rekamMedis->update($request->only(['kunjungan_id', 'diagnosa', 'tindakan']));

    // Update Resep (Prescription)
    $resep = $rekamMedis->resep->first();
    if ($resep) {
        $resep->update([
            'deskripsi' => $request->input('deskripsi')
        ]);
    }

    // Detach old medications
    $rekamMedis->obats()->detach();

    // Handle updating peralatan
if ($request->has('peralatan_id') && is_array($request->peralatan_id)) {
    $rekamMedis->peralatans()->sync($request->peralatan_id); // Sync peralatan yang dipilih
} else {
    $rekamMedis->peralatans()->detach(); // Hapus semua peralatan jika tidak ada yang dipilih
}


    // Handle the new medications and quantities
    $jumlahObat = $request->input('jumlah_obat', []);
    foreach ($request->input('obat_id', []) as $index => $obatId) {
        $obat = Obat::findOrFail($obatId);
        $jumlah = isset($jumlahObat[$obatId]) ? $jumlahObat[$obatId] : 0; // Default to 0 if not found

        if ($obat->jumlah >= $jumlah) {
            $obat->decrement('jumlah', $jumlah); // Reduce stock of the medication
            $rekamMedis->obats()->attach($obat->id, ['jumlah' => $jumlah]); // Attach medication to Rekam Medis
        } else {
            return back()->with('error', 'Stok obat tidak mencukupi untuk ' . $obat->nama);
        }
    }

    // Handle new image uploads
    if ($request->hasFile('new_images')) {
        foreach ($request->file('new_images') as $image) {
            $path = $image->store('rekam_medis', 'public');
            $rekamMedis->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('rekam_medis.index')->with('success', 'Rekam medis berhasil diupdate.');
}



    public function destroy(RekamMedis $rekamMedis, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        // Delete associated images from storage
        foreach ($rekamMedis->images as $image) {
            Storage::delete('public/' . $image->image_path); // Delete image from storage
        }

        // Permanently delete RekamMedis record (force delete)
        $rekamMedis->forceDelete();  // This will permanently delete the record

        return redirect()->route('rekam_medis.index')->with('success', 'Rekam Medis berhasil dihapus.');
    }


public function deleteImage($id)
{
    $image = RekamMedisImage::find($id);
    if ($image) {
        Storage::delete($image->image_path);
        $image->delete();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan'], 404);
}



public function nota($id)
{
    $rekamMedis = RekamMedis::with(['kunjungan.pasien', 'obats', 'peralatans'])->findOrFail($id);

    $totalHarga = $rekamMedis->obats->sum(function ($obat) {
        return $obat->pivot->jumlah * $obat->harga;
    }) + $rekamMedis->peralatans->sum('harga');

    return view('rekam_medis.nota', compact('rekamMedis', 'totalHarga'));
}

}
