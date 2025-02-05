<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

        $diagnosaCount = RekamMedis::whereHas('kunjungan', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->selectRaw('kunjungan_id, count(diagnosa) as total')
            ->groupBy('kunjungan_id')
            ->get();

        $kunjunganhistory = Kunjungan::with(['dokter', 'pasien', 'rekamMedis.obats', 'rekamMedis.peralatans', 'rekamMedis.images'])
            ->where('user_id', $user->id)
            ->get();

        $dokter = Dokter::all();
        $pasien = Pasien::where('user_id', $user->id)->get();
        $kunjungan = Kunjungan::where('user_id', $user->id)->get();
        $jumlah = Kunjungan::where('user_id', $user->id)->count();

        return view('home', compact('jumlahPasien', 'diagnosaCount', 'pasien', 'kunjungan', 'jumlah', 'dokter', 'kunjunganhistory'));
    }
}
