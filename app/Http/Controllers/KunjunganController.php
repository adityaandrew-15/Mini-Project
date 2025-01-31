<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Peralatan;
use App\Models\RekamMedis;
use App\Models\Resep;
use App\Notifications\DokterAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KunjunganController extends Controller
{
    public function index(Request $request)
{
    if (auth()->user()->hasRole('admin|dokter')) {
        $layout = 'layouts.sidebar';
        $content = 'side';
    } else {
        $layout = 'layouts.app';
        $content = 'content';
    }

    // Ambil nilai input pencarian
    $searchPasien = $request->get('search_pasien');
    $searchDokter = $request->get('search_dokter');
    $searchTanggal = $request->get('search_tanggal');

    $kunjungans = Kunjungan::when($searchPasien, function ($query, $searchPasien) {
        return $query->whereHas('pasien', function ($query) use ($searchPasien) {
            $query->where('nama', 'like', '%' . $searchPasien . '%');
        });
    })
    ->when($searchDokter, function ($query, $searchDokter) {
        return $query->whereHas('dokter', function ($query) use ($searchDokter) {
            $query->where('nama', 'like', '%' . $searchDokter . '%');
        });
    })
    ->when($searchTanggal, function ($query, $searchTanggal) {
        return $query->whereDate('tanggal_kunjungan', $searchTanggal);
    })
    ->with(['pasien', 'dokter'])
    ->paginate(10);

    // $pasiens = auth()->user()->hasRole('admin') ? Pasien::all() : Pasien::where('user_id', auth()->id())->get();
    $dokters = Dokter::all();
    $pasiens = Pasien::all();
    $obats = Obat::all(); // Ensure this line is present
    $peralatans = Peralatan::all();

    return view('kunjungan.index', compact('kunjungans', 'pasiens', 'dokters', 'obats', 'peralatans', 'layout', 'content'));
}

    public function create()
    {
        $pasiens = Pasien::where('user_id', auth()->id())->get();
        $dokters = Dokter::all();
        return view('kunjungan.create', compact('pasiens', 'dokters'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'keluhan' => 'required',
            'dokter_id' => auth()->user()->hasRole('admin') ? 'required|exists:dokters,id' : 'nullable|exists:dokters,id',
            'tanggal_kunjungan' => 'required|date',
        ]);

        // Ambil semua data dari request
        $data = $request->all();
        $data['user_id'] = auth()->id();  // Tambahkan user_id ke data

        Kunjungan::create($data);

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil ditambahkan.');
        } else {
            return redirect()->route('home')->with('success', 'Data kunjungan berhasil ditambahkan, harap tunggu beberapa saat lagi');
        }
    }

    public function storeRekamMedis(Request $request, $kunjungan_id)
{
    $validated = $request->validate([
        'kunjungan_id' => 'required|exists:kunjungans,id',
        'diagnosa' => 'required|string',
        'tindakan' => 'required|string',
        'deskripsi' => 'required|string',
        'obat_id.*' => 'exists:obats,id',
        'jumlah_obat.*' => 'required|integer|min:1',
        'peralatan_id.*' => 'exists:peralatans,id',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Get the kunjungan record
    $kunjungan = Kunjungan::findOrFail($validated['kunjungan_id']);

    // Create the medical record
    $rekamMedis = RekamMedis::create([
        'kunjungan_id' => $validated['kunjungan_id'],
        'pasien_id' => $kunjungan->pasien_id,  // Menambahkan pasien_id
        'diagnosa' => $validated['diagnosa'],
        'tindakan' => $validated['tindakan'],
    ]);

    // Save the prescription
    Resep::create([
        'kunjungan_id' => $validated['kunjungan_id'],
        'rekam_medis_id' => $rekamMedis->id,
        'deskripsi' => $validated['deskripsi'],
    ]);

    // Handle the medication and quantities
    foreach ($validated['obat_id'] as $index => $obatId) {
        $obat = Obat::findOrFail($obatId);
        $jumlah = $validated['jumlah_obat'][$index];

        if ($obat->jumlah >= $jumlah) {
            $obat->decrement('jumlah', $jumlah);  // Reduce stock
            $rekamMedis->obats()->attach($obat->id, ['jumlah' => $jumlah]);  // Save to pivot table
        } else {
            return back()->with('error', 'Stok obat tidak mencukupi untuk ' . $obat->obat);
        }
    }

    // Handle equipment if any
    if (!empty($validated['peralatan_id'])) {
        $rekamMedis->peralatans()->sync($validated['peralatan_id']);
    }

    // Handle the images if any
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('rekam_medis_images', 'public');
            RekamMedisImage::create([
                'rekam_medis_id' => $rekamMedis->id,
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('kunjungan.index')->with('success', 'Rekam medis berhasil ditambahkan.');
}

    public function show(Kunjungan $kunjungan)
    {
        return view('kunjungan.show', compact('kunjungan'));
    }

    public function edit(Kunjungan $kunjungan)
    {
        $pasiens = Pasien::all();
        $dokter = Dokter::all();
        return view('kunjungan.edit', compact('kunjungan', 'pasiens', 'dokter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal_kunjungan' => 'required|date',
        ]);

        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->load('dokter');
        $kunjungan->load('pasien');
        $kunjungan->dokter_id = $request->dokter_id;
        $kunjungan->is_assigned = 1;
        $kunjungan->save();

        $kunjungan->pasien->user->notify(new DokterAssignedNotification($kunjungan));
        return redirect()->route('kunjungan.index')->with('success', 'Dokter berhasil ditambahkan');
    }

    public function destroy(Kunjungan $kunjungan)
{
    // Cek apakah kunjungan memiliki rekam medis
    if ($kunjungan->rekamMedis && $kunjungan->rekamMedis->count() > 0) {
        if (Auth()->user()->hasRole('admin')) {
            return redirect()->route('kunjungan.index')->with('error', 'Data tidak bisa dihapus karena sudah memiliki rekam medis.');
        } else {
            return redirect()->route('home')->with('error', 'Data tidak bisa dihapus karena sudah dilakukan pemeriksaan.');
        }
    } else {
        // Hapus rekam medis terkait jika ada
        if ($kunjungan->rekamMedis) {
            $kunjungan->rekamMedis->delete();
        }

        // Hapus kunjungan
        $kunjungan->delete();

        if (Auth()->user()->hasRole('admin')) {
            return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dihapus.');
        } else {
            return redirect()->route('home')->with('success', 'Data kunjungan berhasil dihapus.');
        }
    }
}

    public function dashboard(Request $request)
    {
        $doctor = auth()->user();
        $user = Auth::user();
        $dokter = $user->dokter;  // Get the logged-in doctor

        // Get the search terms
        $searchTerbaru = $request->get('search_terbaru');
        $searchKunjungan = $request->get('search_kunjungan');

        // For the "Data Terbaru Kunjungan Pasien" section
        $kunjungans = Kunjungan::where('dokter_id', $doctor->dokter->id)
            ->where('status', 'UNDONE')
            ->when($searchTerbaru, function ($query, $search) {
                return $query->whereHas('pasien', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // For the "Data Kunjungan Pasien" section
        $kunjungan = Kunjungan::where('dokter_id', $doctor->dokter->id)
            ->where('status', 'DONE')
            ->when($searchKunjungan, function ($query, $search) {
                return $query->whereHas('pasien', function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Additional counts
        $count = Kunjungan::where('dokter_id', $doctor->dokter->id)
            ->where('status', 'UNDONE')
            ->count();

        $selesai = Kunjungan::where('dokter_id', $doctor->dokter->id)
            ->where('status', 'DONE')
            ->count();

        return view('home-dokter', compact('kunjungans', 'kunjungan', 'count', 'selesai', 'dokter'));
    }

    public function updateDiagnosa(Request $request)
    {
        // Validate the request
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungans,id',
            'diagnosa' => 'required|string',
        ]);

        // Find the Kunjungan by ID
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);

        // Update the diagnosis
        $kunjungan->diagnosa = $request->diagnosa;
        $kunjungan->save();

        // Redirect back with a success message
        return redirect()->route('home-dokter')->with('success', 'Diagnosa berhasil diperbarui');
    }

    public function adminDashboard()
    {
        // Ambil data kunjungan per bulan
        $kunjunganPerBulan = DB::table('kunjungan')
            ->select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('bulan')
            ->get();

        return view('admin-home', compact('kunjunganPerBulan'));
    }
}
