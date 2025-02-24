<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\History;
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

        $searchPasien = $request->get('search_pasien');
        $searchDokter = $request->get('search_dokter');
        $searchTanggalStart = $request->get('search_tanggal_start');
        $searchTanggalEnd = $request->get('search_tanggal_end');

        $kunjungans = Kunjungan::query();
        $donekunjungans = Kunjungan::query();
        $pendingkunjungans = Kunjungan::query();

        if (auth()->user()->hasRole('dokter')) {
            $dokterId = auth()->user()->dokter->id;
            $kunjungans = $kunjungans->where('dokter_id', $dokterId);
            $donekunjungans = $donekunjungans->where('dokter_id', $dokterId);
            $pendingkunjungans = $pendingkunjungans->where('dokter_id', $dokterId);
        }

        $kunjungans = $kunjungans
            ->when($searchPasien, function ($query, $searchPasien) {
                return $query->whereHas('pasien', function ($query) use ($searchPasien) {
                    $query->where('nama', 'like', '%' . $searchPasien . '%');
                });
            })
            ->when($searchDokter, function ($query, $searchDokter) {
                return $query->whereHas('dokter', function ($query) use ($searchDokter) {
                    $query->where('nama', 'like', '%' . $searchDokter . '%');
                });
            })
            ->when($searchTanggalStart && $searchTanggalEnd, function ($query) use ($searchTanggalStart, $searchTanggalEnd) {
                return $query->whereBetween('tanggal_kunjungan', [$searchTanggalStart, $searchTanggalEnd]);
            })
            ->when($searchTanggalStart && !$searchTanggalEnd, function ($query) use ($searchTanggalStart) {
                return $query->whereDate('tanggal_kunjungan', '>=', $searchTanggalStart);
            })
            ->when(!$searchTanggalStart && $searchTanggalEnd, function ($query) use ($searchTanggalEnd) {
                return $query->whereDate('tanggal_kunjungan', '<=', $searchTanggalEnd);
            })
            ->where('status', 'UNDONE')
            ->with(['pasien', 'dokter', 'rekamMedis'])
            ->paginate(10);

        $donekunjungans = $donekunjungans
            ->when($searchPasien, function ($query, $searchPasien) {
                return $query->whereHas('pasien', function ($query) use ($searchPasien) {
                    $query->where('nama', 'like', '%' . $searchPasien . '%');
                });
            })
            ->when($searchDokter, function ($query, $searchDokter) {
                return $query->whereHas('dokter', function ($query) use ($searchDokter) {
                    $query->where('nama', 'like', '%' . $searchDokter . '%');
                });
            })
            ->when($searchTanggalStart && $searchTanggalEnd, function ($query) use ($searchTanggalStart, $searchTanggalEnd) {
                return $query->whereBetween('tanggal_kunjungan', [$searchTanggalStart, $searchTanggalEnd]);
            })
            ->when($searchTanggalStart && !$searchTanggalEnd, function ($query) use ($searchTanggalStart) {
                return $query->whereDate('tanggal_kunjungan', '>=', $searchTanggalStart);
            })
            ->when(!$searchTanggalStart && $searchTanggalEnd, function ($query) use ($searchTanggalEnd) {
                return $query->whereDate('tanggal_kunjungan', '<=', $searchTanggalEnd);
            })
            ->where('status', 'DONE')
            ->with(['pasien', 'dokter', 'rekamMedis'])
            ->paginate(10);

        $pendingkunjungans = $pendingkunjungans
            ->when($searchPasien, function ($query, $searchPasien) {
                return $query->whereHas('pasien', function ($query) use ($searchPasien) {
                    $query->where('nama', 'like', '%' . $searchPasien . '%');
                });
            })
            ->when($searchDokter, function ($query, $searchDokter) {
                return $query->whereHas('dokter', function ($query) use ($searchDokter) {
                    $query->where('nama', 'like', '%' . $searchDokter . '%');
                });
            })
            ->when($searchTanggalStart && $searchTanggalEnd, function ($query) use ($searchTanggalStart, $searchTanggalEnd) {
                return $query->whereBetween('tanggal_kunjungan', [$searchTanggalStart, $searchTanggalEnd]);
            })
            ->when($searchTanggalStart && !$searchTanggalEnd, function ($query) use ($searchTanggalStart) {
                return $query->whereDate('tanggal_kunjungan', '>=', $searchTanggalStart);
            })
            ->when(!$searchTanggalStart && $searchTanggalEnd, function ($query) use ($searchTanggalEnd) {
                return $query->whereDate('tanggal_kunjungan', '<=', $searchTanggalEnd);
            })
            ->where('status', 'PENDING')
            ->with(['pasien', 'dokter', 'rekamMedis'])
            ->paginate(10);

        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        $obats = Obat::all();
        $peralatans = Peralatan::all();

        return view('kunjungan.index', compact('pendingkunjungans', 'donekunjungans', 'kunjungans', 'pasiens', 'dokters', 'obats', 'peralatans', 'layout', 'content'));
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

    public function show($id)
    {
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'rekamMedis'])->findOrFail($id);
        return response()->json($kunjungan);
    }

    public function showDetail($id)
    {
        $kunjungan = Kunjungan::with([
            'pasien',
            'dokter',
            'rekamMedis',
            'rekamMedis.obats',
            'rekamMedis.peralatans',
            'rekamMedis.images'
        ])->findOrFail($id);

        return response()->json([
            'kunjungan' => $kunjungan,
            'rekamMedis' => $kunjungan->rekamMedis,
        ]);
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
        // Cari dan hapus semua rekam medis yang terkait dengan kunjungan ini
        $rekamMedis = RekamMedis::where('kunjungan_id', $kunjungan->id)->get();

        if ($rekamMedis->count() > 0) {
            foreach ($rekamMedis as $rekam) {
                // Hapus gambar dari storage jika ada
                if ($rekam->image) {
                    Storage::delete('public/' . $rekam->image);
                }
                // Hapus rekam medis secara permanen
                $rekam->forceDelete();
            }
        }

        // Hapus kunjungan setelah semua rekam medisnya dihapus
        $kunjungan->forceDelete();

        if (Auth()->user()->hasRole('admin')) {
            return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan dan rekam medis berhasil dihapus.');
        } else {
            return redirect()->route('home')->with('success', 'Data kunjungan dan rekam medis berhasil dihapus.');
        }
    }

    public function reject(Kunjungan $kunjungan)
    {
        // Update status kunjungan menjadi 'REJECT'
        $kunjungan->status = 'REJECT';
        $kunjungan->save();

        // Mengembalikan respon berdasarkan role pengguna
        if (Auth()->user()->hasRole('admin')) {
            return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil ditolak.');
        } else {
            return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil ditolak.');
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

    public function kunjhistory(Request $request)
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

        $kunjungans = Kunjungan::query();

        // Filter berdasarkan peran user
        if (auth()->user()->hasRole('dokter')) {
            $dokterId = auth()->user()->dokter->id;  // Ambil ID dokter yang sedang login
            $kunjungans = $kunjungans->where('dokter_id', $dokterId);
        }

        // Filter pencarian
        $kunjungans = $kunjungans
            ->when($searchPasien, function ($query, $searchPasien) {
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
            ->where('status', 'DONE')
            ->with(['pasien', 'dokter', 'rekamMedis'])
            ->paginate(10);

        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        $obats = Obat::all();
        $peralatans = Peralatan::all();

        return view('kunjungan.history', compact('kunjungans', 'pasiens', 'dokters', 'obats', 'peralatans', 'layout', 'content'));
    }

    public function kunjhistoryshow($id)
    {
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'rekamMedis' => function ($query) {
            $query->with(['obats', 'images']);
        }])->findOrFail($id);

        return view('kunjungan.detail', compact('kunjungan'));
    }

    public function pendingdetails($id)
    {
        $kunjungan = Kunjungan::with(['pasien', 'dokter', 'rekamMedis' => function ($query) {
            $query->with(['obats', 'images']);
        }])->findOrFail($id);

        // $rekamMedis = RekamMedis::with(['kunjungan.pasien', 'obats', 'peralatans'])->findOrFail($id);
        // $totalHarga = $rekamMedis->obats->sum(function ($obat) {
        //     return $obat->pivot->jumlah * $obat->harga;
        // }) + $rekamMedis->peralatans->sum('harga');

        return view('kunjungan.pendingdetail', compact('kunjungan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $kunjungan = Kunjungan::with(['rekamMedis.obats', 'rekamMedis.peralatans', 'pasien'])->find($id);

        // Log the kunjungan and its status for debugging
        \Log::info('Kunjungan found: ', ['kunjungan' => $kunjungan]);

        if (!$kunjungan || $kunjungan->status != 'PENDING') {
            \Log::error('Kunjungan error', ['status' => $kunjungan ? $kunjungan->status : 'null']);
            return response()->json(['error' => 'Kunjungan tidak valid atau sudah selesai'], 400);
        }

        $rekamMedis = $kunjungan->rekamMedis()->first();

        // Log the rekamMedis for debugging
        \Log::info('Rekam Medis found: ', ['rekamMedis' => $rekamMedis]);

        if (!$rekamMedis) {
            \Log::error('Rekam Medis not found for Kunjungan ID', ['kunjungan_id' => $id]);
            return response()->json(['error' => 'Rekam medis tidak ditemukan.'], 400);
        }

        $totalHargaObat = $rekamMedis->obats->sum(function ($obat) {
            return $obat->pivot->jumlah * $obat->harga;
        });

        $totalHargaPeralatan = $rekamMedis->peralatans->sum('harga');
        $totalPembayaran = $totalHargaObat + $totalHargaPeralatan;

        $metodePembayaran = $request->input('method', 'cash');

        // Simpan riwayat pembayaran
        History::create([
            'type' => 'payment',
            'action' => 'paid',
            'reference_id' => $rekamMedis->id,
            'details' => [
                'patient_name' => $kunjungan->pasien->nama,
                'total' => $totalPembayaran,
                'payment_method' => $metodePembayaran
            ],
        ]);

        // Update status kunjungan menjadi DONE
        $kunjungan->status = 'DONE';
        $kunjungan->save();

        return response()->json(['success' => 'Pembayaran berhasil diselesaikan.']);
    }

    public function konfirmasiPembayaran($id)
    {
        $rekamMedis = RekamMedis::with(['kunjungan.pasien', 'obats', 'peralatans'])->findOrFail($id);

        $totalHarga = $rekamMedis->obats->sum(function ($obat) {
            return $obat->pivot->jumlah * $obat->harga;
        }) + $rekamMedis->peralatans->sum('harga');

        return view('kunjungan.konfirmasi', compact('rekamMedis', 'totalHarga'));
    }
}
