<?php

namespace App\Http\Controllers;

use App\Models\JadwalPraktek;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalPraktekController extends Controller
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
    $dokters = Dokter::all();

    // Pencarian
    $search = $request->input('search');
    $hari = $request->input('hari');
    $jam = $request->input('jam');

    $jadwalPrakteks = JadwalPraktek::with('dokter')
        ->when($search, function ($query, $search) {
            $query->whereHas('dokter', function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            })->orWhere('hari', 'like', "%{$search}%");
        })
        ->when($hari, function ($query, $hari) {
            $query->where('hari', $hari);
        })
        ->when($jam, function ($query, $jam) {
            $query->where('jam_mulai', '<=', $jam)
                  ->where('jam_selesai', '>=', $jam);
        })
        ->paginate(10);

    return view('jadwal_praktek.index', compact('dokters', 'jadwalPrakteks', 'layout', 'content'));
}



    public function create()
    {
        $dokters = Dokter::all();
        return view('jadwal_praktek.create', compact('dokters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalPraktek::create($request->all());
        return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil ditambahkan.');
    }

    public function show(JadwalPraktek $jadwalPraktek)
    {
        return view('jadwal_praktek.show', compact('jadwalPraktek'));
    }

    public function edit(JadwalPraktek $jadwalPraktek)
    {
        $dokters = Dokter::all();
        return view('jadwal_praktek.edit', compact('jadwalPraktek', 'dokters'));
    }

    public function update(Request $request, JadwalPraktek $jadwalPraktek)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwalPraktek->update($request->all());
        return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil diperbarui.');
    }

    public function destroy(JadwalPraktek $jadwalPraktek)
    {
        $jadwalPraktek->delete();
        return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil dihapus.');
    }
}
