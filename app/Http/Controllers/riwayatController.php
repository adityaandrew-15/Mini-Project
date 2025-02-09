<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class riwayatController extends Controller
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

                $kunjunganhistory = Kunjungan::query();

if (auth()->user()->hasRole('dokter')) {
    $dokterId = auth()->user()->dokter->id;
    $kunjunganhistory = $kunjunganhistory->where('dokter_id', $dokterId);
}

// Filter hanya kunjungan yang memiliki rekam medis
$kunjunganhistory = $kunjunganhistory->whereHas('rekamMedis')->get();

if ($kunjunganhistory->isEmpty()) {
    return 'Tidak ada riwayat kunjungan dengan rekam medis.';
}
                
        
            $dokter = Dokter::all();
            $pasien = Pasien::where('user_id', auth()->id())->get();
            $kunjungan = Kunjungan::where('user_id', auth()->id())->get();
            $jumlah = Kunjungan::count();
        
            return view('riwayat', compact('jumlahPasien', 'diagnosaCount', 'pasien', 'kunjungan', 'jumlah', 'dokter', 'kunjunganhistory'));
        }
}
