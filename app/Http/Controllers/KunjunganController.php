<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Notifications\DokterAssignedNotification;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index(Request $request)
{
    if(auth()->user()->hasRole('admin|dokter')){
        $layout = 'layouts.sidebar';
        $content = 'side';
    }else{
        $layout = 'layouts.app';
        $content = 'content';
    }
    $search = $request->get('search');

    $kunjungans = Kunjungan::when($search, function ($query, $search) {
        return $query->whereHas('pasien', function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })->orWhereHas('dokter', function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        });
    })
    ->with(['pasien', 'dokter'])
    ->paginate(10);

    $pasiens = Pasien::all();$pasiens = Pasien::where('user_id', auth()->id())->get();  // Fetch all patients
    $dokters = Dokter::all();  // Fetch all doctors

    return view('kunjungan.index', compact('kunjungans', 'pasiens', 'dokters','layout','content'));  // Pass dokters to the view
}





    public function create()
    {
        $pasiens = Pasien::where('user_id', auth()->id())->get();
        $dokters = Dokter::all();
        return view('kunjungan.create', compact('pasiens', 'dokters'));
    }

    public function store(Request $request)
    {
        if(auth()->user()->hasRole('admin')){
            $request->validate([
                'pasien_id' => 'required|exists:pasiens,id',
                'keluhan' => 'required',
                'dokter_id' => 'required|exists:dokters,id',
                'tanggal_kunjungan' => 'required|date',
            ]);
        }else{
            $request->validate([
                'pasien_id' => 'required|exists:pasiens,id',
                'keluhan' => 'required',
                'tanggal_kunjungan' => 'required|date',
            ]);
        }

        $data = $request->all();
        $data['user_id'] = auth()->id();

        Kunjungan::create($data);
        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil ditambahkan.');
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
        $kunjungan->delete();
        return redirect()->route('kunjungan.index')->with('success', 'Data kunjungan berhasil dihapus.');
    }

    public function dashboard(Request $request)
{
    $doctor = auth()->user(); // Get the logged-in doctor


    // Ambil nilai pencarian dari request (jika ada)
    $search = $request->get('search');

    // Get the visits related to the logged-in doctor
    // $kunjungan = Kunjungan::where('dokter_id', $doctor->dokter->id) // Filter by the doctor's ID
    //                       ->with('pasien') // Eager load the patient data
    //                       ->get();


    // Get the visits related to the logged-in doctor
    $kunjungans = Kunjungan::when($search, function ($query, $search) {
        return $query->whereHas('pasien', function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })->orWhereHas('dokter', function ($query) use ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        });
    })
    ->with(['pasien', 'dokter', 'resep']) // Pastikan semua relasi dimuat
    ->paginate(10);

    // Return the data to the doctor dashboard view

    return view('home-dokter', compact('kunjungans'));

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

}