<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Peralatan;
use App\Models\RekamMedis;
use App\Models\RekamMedisImage;
use App\Models\Resep;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\select;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $rekamMedis = [];

        if ($user->hasRole('dokter')) {
            // Get only the medical records for the logged-in doctor
            $rekamMedis = RekamMedis::whereHas('kunjungan', function ($query) use ($user) {
                $query->where('dokter_id', $user->id);
            })->with(['resep', 'obats'])->paginate(10);
        } elseif ($user->hasRole('admin')) {
            $rekamMedis = RekamMedis::with(['resep', 'obats'])->paginate(10);
        }

        // Get kunjungan data for the logged-in doctor
        if ($user->hasRole('admin')) {
            $knjgn = Kunjungan::all();
        } elseif ($user->hasRole('dokter')) {
            $knjgn = Kunjungan::where('dokter_id', optional($user->dokter)->id)
                ->where('status', 'UNDONE')
                ->get();
        }
        $obats = Obat::all();
        $peralatans = Peralatan::all();

        return view('rekam_medis.index', compact(
            'rekamMedis',
            'knjgn',
            'obats',
            'peralatans',
        ));
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
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'deskripsi' => 'required|string',
            'obat_id.*' => 'exists:obats,id',
            'jumlah_obat.*' => 'required|integer|min:1',
            'peralatan_id.*' => 'exists:peralatans,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $id_dokter = auth()->user()->id;  // Mendapatkan ID dokter yang login

        // Ambil data kunjungan
        $kunjungan = Kunjungan::findOrFail($validated['kunjungan_id']);

        // Buat rekam medis
        $rekamMedis = RekamMedis::create([
            'kunjungan_id' => $validated['kunjungan_id'],
            'pasien_id' => $kunjungan->pasien_id,
            'diagnosa' => $validated['diagnosa'],
            'tindakan' => $validated['tindakan'],
        ]);

        // Simpan resep
        Resep::create([
            'kunjungan_id' => $validated['kunjungan_id'],
            'rekam_medis_id' => $rekamMedis->id,
            'deskripsi' => $validated['deskripsi'],
        ]);

        // Simpan informasi obat yang berkurang untuk riwayat
        $obatHistory = [];

        foreach ($validated['obat_id'] as $index => $obatId) {
            $obat = Obat::findOrFail($obatId);
            $jumlah = $validated['jumlah_obat'][$index];

            if ($obat->jumlah >= $jumlah) {
                $obat->decrement('jumlah', $jumlah);
                $rekamMedis->obats()->attach($obat->id, ['jumlah' => $jumlah]);

                // Simpan data obat yang berkurang untuk history
                $obatHistory[] = [
                    'nama_obat' => $obat->nama,
                    'jumlah' => $jumlah,
                    'stok_tersisa' => $obat->jumlah
                ];
            } else {
                return back()->with('error', 'Stok obat tidak mencukupi untuk ' . $obat->nama);
            }
        }

        // Update status kunjungan menjadi PENDING
        $kunjungan->status = 'PENDING';
        $kunjungan->save();

        // Simpan informasi peralatan yang digunakan untuk riwayat
        $peralatanHistory = [];

        if (!empty($validated['peralatan_id'])) {
            foreach ($validated['peralatan_id'] as $peralatanId) {
                $peralatan = Peralatan::findOrFail($peralatanId);

                // Simpan data peralatan yang digunakan untuk history
                $peralatanHistory[] = [
                    'nama_peralatan' => $peralatan->nama,
                    'harga' => $peralatan->harga
                ];
            }

            // Simpan peralatan ke rekam medis
            $rekamMedis->peralatans()->sync($validated['peralatan_id']);
        }

        // Simpan riwayat perubahan status ke PENDING, pengurangan obat, dan penggunaan peralatan
        History::create([
            'type' => 'medication',
            'action' => 'prescribed',
            'reference_id' => $rekamMedis->id,
            'details' => [
                'patient_name' => $kunjungan->pasien->nama,
                'status' => 'PENDING',
                'obats' => $obatHistory,
                'peralatans' => $peralatanHistory,  // Tambahkan peralatan ke dalam history
            ],
        ]);

        // Simpan riwayat perubahan status ke PENDING dan pengurangan obat
        History::create([
            'type' => 'medication',
            'action' => 'prescribed',
            'reference_id' => $rekamMedis->id,
            'details' => [
                'patient_name' => $kunjungan->pasien->nama,
                'status' => 'PENDING',
                'obats' => $obatHistory,  // Simpan list obat yang dikurangi
            ],
        ]);

        // Simpan gambar jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rekam_medis', 'public');
                $rekamMedis->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('kunjungan.index')->with('success', 'Rekam medis berhasil ditambahkan dan status diperbarui.');
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
        $validated = $request->validate([
            'diagnosa' => 'required|string|max:255',
            'tindakan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'obat_id.*' => 'exists:obats,id',
            'jumlah_obat.*' => 'required|integer|min:1',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'peralatan_id.*' => 'exists:peralatans,id',
        ]);

        $rekamMedis = RekamMedis::findOrFail($id);

        // Kembalikan stok obat lama
        foreach ($rekamMedis->obats as $oldObat) {
            $oldObat->increment('jumlah', $oldObat->pivot->jumlah);  // Kembalikan stok lama
        }

        // Persiapkan data sinkronisasi obat baru
        $obatSyncData = [];
        foreach ($request->input('obat_id', []) as $obatId) {
            $obat = Obat::findOrFail($obatId);
            $jumlah = $request->input("jumlah_obat.$obatId", 0);

            if ($obat->jumlah < $jumlah) {
                return back()->with('error', 'Stok obat tidak mencukupi untuk ' . $obat->obat);
            }

            $obatSyncData[$obatId] = ['jumlah' => $jumlah];
            $obat->decrement('jumlah', $jumlah);  // Kurangi stok obat baru
        }

        // Sinkronisasi pivot table
        $rekamMedis->obats()->sync($obatSyncData);

        // Update Rekam Medis
        $rekamMedis->update([
            'diagnosa' => $validated['diagnosa'],
            'tindakan' => $validated['tindakan'],
        ]);

        // Update Resep
        $resep = $rekamMedis->resep->first();
        if ($resep) {
            $resep->update(['deskripsi' => $validated['deskripsi']]);
        }

        // Handle Peralatan
        if ($request->has('peralatan_id')) {
            $rekamMedis->peralatans()->sync($request->input('peralatan_id'));
        } else {
            $rekamMedis->peralatans()->detach();
        }

        // Handle image deletion
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imageId) {
                $image = RekamMedisImage::find($imageId);
                if ($image) {
                    Storage::delete('public/' . $image->image_path);
                    $image->delete();
                }
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

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);

        // Jika rekam medis punya gambar, hapus gambar dari storage
        if ($rekamMedis->image) {
            Storage::delete('public/' . $rekamMedis->image);
        }

        // Hapus rekam medis secara permanen
        $rekamMedis->forceDelete();

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
        $kunjungan = Kunjungan::findOrFail($id);

        $totalHarga = $rekamMedis->obats->sum(function ($obat) {
            return $obat->pivot->jumlah * $obat->harga;
        }) + $rekamMedis->peralatans->sum('harga');

        return view('rekam_medis.nota', compact('rekamMedis', 'totalHarga', 'kunjungan'));
    }

    public function pendingnota($id)
    {
        $rekamMedis = RekamMedis::with(['kunjungan.pasien', 'obats', 'peralatans'])->findOrFail($id);
        // $kunjungan = Kunjungan::findOrFail($id);

        $totalHarga = $rekamMedis->obats->sum(function ($obat) {
            return $obat->pivot->jumlah * $obat->harga;
        }) + $rekamMedis->peralatans->sum('harga');

        return view('kunjungan.pendingnota', compact('rekamMedis', 'totalHarga'));
    }

    public function detail($id)
    {
        // Ambil data rekam medis berdasarkan ID
        $rekamMedis = RekamMedis::with(['kunjungan.pasien', 'obats', 'resep', 'images'])->findOrFail($id);

        // Kirim data ke view
        return view('rekam_medis.detail', compact('rekamMedis'));
    }
}
