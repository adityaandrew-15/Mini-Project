@extends('layouts.sidebar')
<style>
    .content-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        /* Grid responsif */
        gap: 15px;
        /* max-width: 1200px; */
        /* margin: auto; */
        padding: 10px;
    }

    .list-item {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .list-item .top,
    .list-item .bottom {
        display: flex;
        /* justify-content: space-between; */
        align-items: center;
        margin-bottom: 5px;
    }

    .list-item .top strong,
    .list-item .bottom strong {
        margin-right: 16px;
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 420px;
    }

    .separator {
        border-top: 1px solid #ddd;
        margin: 10px 0;
    }
</style>
@section('side')
    <div class="m-3">
        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    @if (session('success'))
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: '{{ session('success') }}',
                            showConfirmButton: false,
                            timer: 7000
                        });
                    @endif
                });
            </script>
        @endif
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if ($errors->any())
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Validasi Gagal!',
                        html: `
                <ul style="text-align: left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                        showConfirmButton: false,
                        timer: 10000
                    });
                @endif
            });
        </script>
        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center">
                <h2 class="h2 f-bolder mr-4">Riwayat Kunjungan</h2>
            </div>
        </div>
        <div class="content-table m-2 d-flex col">
            <form method="GET" action="{{ route('kunjungan.index') }}" class="d-flex w-100 gap-2">
                <input type="text" class="search-container w-75 h4" name="search_pasien" placeholder="Cari Nama Pasien"
                    value="{{ request('search_pasien') }}" class="">
                <div class="filter-form d-flex">
                    <input type="text" class="search-container h4" style="width: 200px" name="search_dokter"
                        placeholder="Cari Nama Dokter" value="{{ request('search_dokter') }}" class="">
                    <input type="date" class="search-container h4" style="width: 200px" name="search_tanggal"
                        placeholder="Cari Nama atau No HP" value="{{ request('search_tanggal') }}" class=""
                        onchange="this.form.submit()">
                    <button type="submit" class="btn-filter">Cari</button>
                </div>
                <style>
                    .invisible-btn {
                        opacity: 0;
                        position: absolute;
                        pointer-events: none;
                    }
                </style>
            </form>

            <div class="outer-table">
                <div class="content-table-table">
                    <div class="content-list">
                        @foreach ($kunjunganhistory as $kunj)
                            <div class="list-item">
                                <!-- Atas -->
                                <div class="top">
                                    <strong>Pasien :</strong> <span>{{ $kunj->pasien->nama }}</span>
                                </div>
                                <div class="top">
                                    <strong>Dokter :</strong> <span>{{ auth()->user()->dokter->nama }}</span>
                                </div>

                                <!-- Bawah -->
                                <div class="bottom">
                                    <strong>Keluhab :</strong> <span class="truncate">{{ $kunj->keluhan }}</span>
                                </div>
                                <div class="bottom">
                                    <strong>Tanggal :</strong> <span>{{ $kunj->tanggal_kunjungan }}</span>
                                </div>

                                <div class="separator"></div>

                                <!-- Tombol -->
                                @if ($kunj->rekamMedis->isNotEmpty())
                                    <a style="width: 200px;" href="#" class="btn-add detail-btn"
                                        data-id="{{ $kunj->rekamMedis->first()->id }}">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>

                                    <!-- Elemen tersembunyi untuk detail -->
                                    <div id="detailContent{{ $kunj->rekamMedis->first()->id }}" class="detail-content"
                                        style="display: none;">
                                        <strong>Pasien:</strong>
                                        {{ $kunj->rekamMedis->first()->kunjungan->pasien->nama }} <br>
                                        <strong>Diagnosa:</strong> {{ $kunj->rekamMedis->first()->diagnosa }}
                                        <br>
                                        <strong>Tindakan:</strong> {{ $kunj->rekamMedis->first()->tindakan }}
                                        <br>
                                        <strong>Obat:</strong><br>
                                        @if ($kunj->rekamMedis->first()->obats->isNotEmpty())
                                            @foreach ($kunj->rekamMedis->first()->obats as $obat)
                                                {{ $obat->obat }} - Jumlah: {{ $obat->pivot->jumlah }}<br>
                                            @endforeach
                                        @else
                                            Tidak ada obat yang terkait <br>
                                        @endif
                                        <strong>Peralatan:</strong><br>
                                        @if ($kunj->rekamMedis->first()->peralatans->isNotEmpty())
                                            @foreach ($kunj->rekamMedis->first()->peralatans as $peralatan)
                                                {{ $peralatan->nama_peralatan }}<br>
                                            @endforeach
                                        @else
                                            Tidak ada peralatan yang terkait <br>
                                        @endif
                                        <strong>Gambar:</strong><br>
                                        @if ($kunj->rekamMedis->first()->images->isNotEmpty())
                                            @foreach ($kunj->rekamMedis->first()->images as $image)
                                                <img src="{{ asset('storage/' . $image->image_path) }}" height="150"
                                                    width="120" class="mb-2" alt="Gambar"><br>
                                            @endforeach
                                         @else
                                            Tidak ada gambar yang terkait <br>
                                        @endif
                                    </div>
                                @else
                                    <p>Tidak ada rekam medis untuk kunjungan ini.</p>
                                @endif
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // Tambahkan event listener ke semua tombol "Detail"
                                        document.querySelectorAll(".detail-btn").forEach(button => {
                                            button.addEventListener("click", function(event) {
                                                event.preventDefault(); // Hindari reload halaman

                                                let id = this.getAttribute("data-id"); // Ambil ID rekam medis
                                                let content = document.getElementById("detailContent" + id)
                                                    .innerHTML; // Ambil isi konten

                                                // Tampilkan SweetAlert
                                                Swal.fire({
                                                    title: 'Detail Rekam Medis',
                                                    html: content,
                                                    showCloseButton: true,
                                                    confirmButtonText: 'Close',
                                                    width: '50%',
                                                    padding: '20px',
                                                    didOpen: () => {
                                                        document.body.style.overflow = 'hidden';
                                                    },
                                                    didClose: () => {
                                                        document.body.style.overflow = 'auto';
                                                    }
                                                });
                                            });
                                        });
                                    });
                                </script>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
