@extends('layouts.sidebar')
<style>

</style>
@section('side')
    <div class="ml-3">
        <div class="m-3">
            <div class="header d-flex t-center a-center">
                <span class="square" style="width: 35px; height: 35px; background: #ccc; margin-right: 10px;"></span>
                <h2 class="title h2 f-bolder">
                    Detail Kunjungan dan Rekam Medis
                </h2>
            </div>

            {{-- first part --}}

            <p class="h4 my-2"><strong>Pasien:</strong><br>
                {{ $kunjungan->pasien->nama }}
            </p>
            <p class="h4 my-2"><strong>Keluhan:</strong><br>
                {{ $kunjungan->keluhan }}</p>
            <p class="h4 my-1"><strong>Dokter:</strong>
                {{ $kunjungan->dokter->nama ?? 'Belum ditentukan' }}
            </p>
            <p class="h4 my-1"><strong>Tanggal Kunjungan:</strong>
                {{ $kunjungan->tanggal_kunjungan }}</p>
            <hr class="my-2">

            {{-- sec part --}}

            <div class="header d-flex t-center a-center">
                <span class="square" style="width: 35px; height: 35px; background: #ccc; margin-right: 10px;"></span>
                <h2 class="title h2 f-bolder">
                    Detail Kunjungan dan Rekam Medis
                </h2>
            </div>
            <div class="d-flex">
                @if ($kunjungan->rekamMedis && $kunjungan->rekamMedis->count() > 0)
                    @foreach ($kunjungan->rekamMedis as $rekamMedis)
                        <div class="w-100">
                            <p class="h4 my-2"><strong>Diagnosa:</strong><br>
                                {{ $rekamMedis->diagnosa }}</p>
                            <p class="h4 my-2"><strong>Tindakan:</strong><br>
                                {{ $rekamMedis->tindakan }}</p>
                            <p class="h4 my-2"><strong>Resep:</strong><br>
                                {{ $rekamMedis->resep->deskripsi ?? 'Tidak ada resep' }}
                            </p>
                        </div>
                        <div class="w-100">
                            <p class="h4 my-1"><strong>Obat:</strong></p>
                            @if ($rekamMedis->obats && $rekamMedis->obats->count() > 0)
                                @foreach ($rekamMedis->obats as $obat)
                                    <p>{{ $obat->obat }} - Jumlah:
                                        {{ $obat->pivot->jumlah }}</p>
                                @endforeach
                            @else
                                <p>Tidak ada obat yang terkait</p>
                            @endif
                            <p class="h4 my-1"><strong>Gambar:</strong></p>
                            @foreach ($rekamMedis->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" height="150" width="120"
                                    class="mb-2" alt="Gambar">
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <p class="h4 my-1">Tidak ada rekam medis untuk kunjungan ini.</p>
                @endif
            </div>
            <hr class="my-2">

            {{-- footer --}}

            <div class="footer">
                {{-- <button type="button" class="px-2 py-1 btn-close red-hover">Tutup</button> --}}
                <a href="{{ route('kunjungan.index') }}" class="btn-close">Kembali</a>
                @if ($kunjungan->rekamMedis()->exists())
                    <a href="{{ route('rekam_medis.nota', $rekamMedis->id) }}" class="btn-cek-nota">
                        Cek Nota
                        <i class="fa-solid fa-print"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
