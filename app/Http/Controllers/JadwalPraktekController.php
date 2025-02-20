<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalPraktek;
use Illuminate\Http\Request;

class JadwalPraktekController extends Controller
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

    $dokters = Dokter::all();

    // Pencarian
    $search = $request->input('search');
    $searchHari = $request->input('search_hari');
    $startTime = $request->input('start_time');
    $endTime = $request->input('end_time');

    $jadwalPrakteks = JadwalPraktek::with('dokter')
        ->when($search, function ($query, $search) {
            $query->whereHas('dokter', function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            });
        })
        ->when($searchHari, function ($query, $searchHari) {
            $query->where('hari', 'like', "%{$searchHari}%");
        })
        ->when($startTime && $endTime, function ($query) use ($startTime, $endTime) {
            // Filter jadwal berdasarkan rentang waktu
            $query->where(function ($query) use ($startTime, $endTime) {
                $query->whereTime('jam_mulai', '>=', $startTime)
                      ->whereTime('jam_selesai', '<=', $endTime);
            });
        })
        ->when($startTime && !$endTime, function ($query) use ($startTime) {
            // Jika hanya memilih start_time, filter berdasarkan jam mulai saja
            $query->whereTime('jam_mulai', '>=', $startTime);
        })
        ->when(!$startTime && $endTime, function ($query) use ($endTime) {
            // Jika hanya memilih end_time, filter berdasarkan jam selesai saja
            $query->whereTime('jam_selesai', '<=', $endTime);
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

        // Cek apakah jadwal bentrok
        $conflict = JadwalPraktek::where('dokter_id', $request->dokter_id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query
                    ->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($query) use ($request) {
                        $query
                            ->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['error' => 'Jadwal pada waktu ini sudah ada.'])->withInput();
        }

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

        // Cek apakah jadwal bentrok kecuali dengan dirinya sendiri
        $conflict = JadwalPraktek::where('dokter_id', $request->dokter_id)
            ->where('hari', $request->hari)
            ->where('id', '!=', $jadwalPraktek->id)
            ->where(function ($query) use ($request) {
                $query
                    ->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($query) use ($request) {
                        $query
                            ->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['error' => 'Jadwal bentrok dengan jadwal lain untuk dokter ini.'])->withInput();
        }

        $jadwalPraktek->update($request->all());
        return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil diperbarui.');
    }

    public function destroy(JadwalPraktek $jadwalPraktek)
    {
        $jadwalPraktek->delete();
        return redirect()->route('jadwal_praktek.index')->with('success', 'Jadwal praktek berhasil dihapus.');
    }
}
