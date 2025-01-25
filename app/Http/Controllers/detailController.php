<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class detailController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jumlahPasien = Pasien::count();

        $kunjunganPerBulan = DB::table('kunjungans')
            ->select(DB::raw('MONTH(tanggal_kunjungan) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('bulan')
            ->get();

        if ($user->role === 'admin') {
            return view('admin-home', compact('jumlahPasien', 'kunjunganPerBulan'));
        }

        $diagnosaCount = RekamMedis::selectRaw('kunjungan_id, count(diagnosa) as total')
            ->groupBy('kunjungan_id')
            ->get();

        $kunjunganhistory = Kunjungan::with(['dokter', 'pasien'])->get();
        $dokter = Dokter::all();
        $pasien = Pasien::where('user_id', auth()->id())->get();
        $kunjungan = Kunjungan::where('user_id', auth()->id())->get();
        $jumlah = Kunjungan::count();
        return view('detail', compact('jumlahPasien', 'diagnosaCount', 'pasien', 'kunjungan', 'jumlah', 'dokter', 'kunjunganhistory'));
    }
}
