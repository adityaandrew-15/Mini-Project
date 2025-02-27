<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;

class PembayaranController extends Controller
{
    public function konfirmasi($id)
    {
        $rekamMedis = RekamMedis::with(['kunjungan.pasien', 'obats', 'peralatans'])->findOrFail($id);

        $totalHarga = $rekamMedis->obats->sum(function ($obat) {
            return $obat->pivot->jumlah * $obat->harga;
        }) + $rekamMedis->peralatans->sum('harga');

        return view('pembayaran.konfirmasi', compact('rekamMedis', 'totalHarga'));
    }

    public function proses(Request $request)
    {
        $rekamMedis = RekamMedis::findOrFail($request->rekamMedis_id);
        $totalHarga = $request->totalHarga;
        $metode = $request->metode;

        if ($metode === 'cash') {
            return response()->json([
                'message' => "Selesaikan pembayaran sebesar Rp " . number_format($totalHarga, 0, ',', '.') . " dengan cash.",
                'redirect' => route('pendingnota', $rekamMedis->id)
            ]);
        } else {
            return response()->json([
                'message' => "Selesaikan pembayaran sebesar Rp " . number_format($totalHarga, 0, ',', '.') . " melalui transfer " . $request->bank,
                'redirect' => route('pembayaran.formTransfer', ['id' => $rekamMedis->id, 'bank' => $request->bank])
            ]);
        }
    }

    public function formTransfer($id, $bank)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        return view('pembayaran.transfer', compact('rekamMedis', 'bank'));
    }
}
