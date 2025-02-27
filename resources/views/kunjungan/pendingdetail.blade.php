@extends('layouts.sidebar')
<style>

</style>
@section('side')
    <div class="ml-3">
        <div class="m-3">
            <div class="header d-flex t-center a-center">
                <span class="square" style="width: 35px; height: 35px; background: #ccc; margin-right: 10px;"></span>
                <h2 class="title h2 f-bolder">
                    Detail Kunjungan Pasien
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
                    Detail Rekam Medis Pasien
                </h2>
            </div>
            <div class="d-flex">
                @if ($kunjungan->rekamMedis && $kunjungan->rekamMedis->count() > 0)
                    @foreach ($kunjungan->rekamMedis as $rekamMedis)
                        <div class="w-100 mr-1">
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
                                <img src="{{ asset('storage/' . $image->image_path) }}" height="300" width="auto"
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
                {{-- Tombol Kembali dengan kondisi berdasarkan peran --}}
                <a href="{{ auth()->user()->hasRole('admin') || auth()->user()->hasRole('dokter') ? route('kunjungan.index') : route('home') }}"
                    class="btn-close">
                    Kembali
                </a>

                @if ($kunjungan->rekamMedis->isNotEmpty())
                    <a href="{{ route('pendingnota', $kunjungan->rekamMedisSelect->id) }}" class="btn-cek-nota">
                        Detail Pembayaran
                        <i class="fa-solid fa-print"></i>
                    </a>
                @elseif($kunjungan->status == 'UNDONE')
                    <form id="delete-form-{{ $kunjungan->id }}" action="{{ route('kunjungan.destroy', $kunjungan->id) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="submit" class="btn-add" onclick="confirmDelete({{ $kunjungan->id }})">
                        Batalkan Kunjungan
                    </button>
                    <script>
                        function confirmDelete(id) {
                            Swal.fire({
                                title: 'Tolak Kunjungan ini?',
                                text: "Data kunjungan akan ditolak!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Submit form hapus
                                    document.getElementById('delete-form-' + id).submit();
                                }
                            });
                        }
                    </script>
                @endif
            </div>
        </div>
    </div>
@endsection

{{-- 
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Porro, libero fuga! Modi reprehenderit alias similique, provident maxime enim dolorem fugit, perspiciatis dicta accusamus magni sunt voluptatum odio sed dolor deleniti.

Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio dolor aliquam dolorem aperiam vitae eos enim, quia quod qui nesciunt doloremque atque sapiente molestias quos laudantium modi tempora id cum?

Lorem ipsum dolor sit amet consectetur, adipisicing elit. Qui odit cum aut aspernatur eligendi sit odio eius dicta, architecto commodi atque consequatur dolor soluta velit rerum esse aliquid? Recusandae, mollitia.

Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos neque quis sequi, deserunt totam quia et. Asperiores vel eaque, at maiores animi iste perspiciatis incidunt cupiditate obcaecati, iure, ex accusamus!

Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eius in laboriosam deserunt ullam cumque, harum odio minus voluptates alias quos fugit cum dolor id, voluptate consequatur omnis provident dignissimos. Alias! 
--}}
