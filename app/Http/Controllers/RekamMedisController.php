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
    if(auth()->user()->hasRole('admin|dokter')){
        $layout = 'layouts.sidebar';
        $content = 'side';
    } else {
        $layout = 'layouts.app';
        $content = 'content';
    }
    
    $search = $request->input('search');

    // Query for searching by patient's name, diagnosis, and action
    $rekamMedis = RekamMedis::with(['resep', 'obats'])
    ->whereHas('kunjungan.pasien', function($query) use ($search) {
        $query->where('nama', 'like', "%$search%");
    })
    ->where(function ($query) use ($search) {
        $query->orWhere('diagnosa', 'like', "%$search%")
              ->orWhere('tindakan', 'like', "%$search%");
    })
    ->paginate(10);

    // Get all kunjungan data
    $kunjungans = Kunjungan::with('pasien')->get();
    $obats = Obat::all(); // Ambil semua data obat dari database
    $peralatans = Peralatan::all(); // Fetch peralatan data

    // Pass the data to the view
    return view('rekam_medis.index', compact('rekamMedis', 'kunjungans', 'obats', 'peralatans', 'layout', 'content'));
}


    public function create()
    {
        $kunjungans = Kunjungan::all();
        return view('rekam_medis.create', compact('kunjungans'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'kunjungan_id' => 'required',
        'diagnosa' => 'required',
        'tindakan' => 'required',
        'deskripsi' => 'required|string',
        'obat_id.*' => 'exists:obats,id',
        'jumlah_obat.*' => 'required|integer|min:1',
        'peralatan_id.*' => 'exists:peralatans,id', // Validasi peralatan
    ]);

    $rekamMedis = RekamMedis::create([
        'kunjungan_id' => $validated['kunjungan_id'],
        'diagnosa' => $validated['diagnosa'],
        'tindakan' => $validated['tindakan'],
        'pasien_id' => Kunjungan::find($validated['kunjungan_id'])->pasien_id,
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

    // Handle the new medications and quantities
    $jumlahObat = $request->input('jumlah_obat', []);
    try {
        foreach ($request->input('obat_id', []) as $index => $obatId) {
            $obat = Obat::findOrFail($obatId);
            $jumlah = isset($jumlahObat[$obatId]) ? $jumlahObat[$obatId] : 0; // Default to 0 if not found

            if ($obat->jumlah >= $jumlah) {
                $obat->decrement('jumlah', $jumlah); // Reduce stock of the medication
                $rekamMedis->obats()->attach($obat->id, ['jumlah' => $jumlah]); // Attach medication to Rekam Medis
            } else {
                throw new \Exception('Stok obat tidak mencukupi untuk ' . $obat->nama);
            }
        }
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }

    $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);
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
        $kunjungans = Kunjungan::all();
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

public function showNota($id)
{
    $rekamMedis = RekamMedis::with(['obats', 'peralatans'])->findOrFail($id);

    // Calculate total expenses
    $totalObat = $rekamMedis->obats->sum(function($obat) {
        return $obat->harga * $obat->pivot->jumlah; // Assuming 'harga' is the price field in the Obat model
    });

    $totalPeralatan = $rekamMedis->peralatans->sum('harga'); // Assuming 'harga' is the price field in the Peralatan model

    $totalPayment = $totalObat + $totalPeralatan;

    return view('rekam_medis.nota', compact('rekamMedis', 'totalPayment'));
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