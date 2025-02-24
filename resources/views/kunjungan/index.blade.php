@extends('layouts.sidebar')

<style>
    .tabs {
        display: flex;
        border-bottom: 2px solid #ddd;
        justify-content: flex-end;
    }

    .tab-button {
        background: none;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 16px;
        color: #555;
        border-bottom: 3px solid transparent;
        transition: 0.3s;
    }

    .tab-button.active {
        border-bottom: 3px solid #007bff;
        color: #007bff;
    }

    .tab-content {
        display: none;
        /* padding: 15px; */
        /* border: 1px solid #ddd; */
        margin-top: -1px;
    }

    .tab-content.active {
        display: block;
    }

    .content-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        /* Grid responsif */
        gap: 15px;
        /* max-width: 1200px; */
        /* margin: auto; */
        padding: 10px;
        height: 600px;
    }

    .list-item {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 250px;
        max-width: 480px;
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
        max-width: 220px;
    }

    .separator {
        border-top: 1px solid #ddd;
        margin: 10px 0;
    }
</style>
@section('side')
    <div class="mr-3 ml-3">
        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center mx-2">
                <h2 class="h2 f-bolder mr-4">Data Kunjungan</h2>
                <div class="btn"></div>
                <button type="button" class="btn-add" id="btnOpenAddModal">
                    Tambah Data Kunjungan
                </button>
            </div>
        </div>
        <hr class="mr-3 ml-3">
        <div class="content-table m-2 d-flex col">
            <form method="GET" action="{{ route('kunjungan.index') }}" class="d-flex w-100 gap-2">
                <div class="d-flex w-100 col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Cari Pasien</label>
                    <input type="text" class="search-container w-100 h4" name="search_pasien"
                        placeholder="Cari Nama Pasien" value="{{ request('search_pasien') }}" class="">
                </div>
                <div class="filter-form d-flex w-100 col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Cari Dokter</label>
                    <input type="text" class="search-container h4 w-100" name="search_dokter"
                        placeholder="Cari Nama Dokter" value="{{ request('search_dokter') }}" class="">
                    {{-- <button type="submit" class="btn-filter">Cari</button> --}}
                </div>
                <div class="filter-form d-flex  col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Dari</label>
                    <input type="date" class="search-container h4" name="search_tanggal_start"
                        value="{{ request('search_tanggal_start') }}" onchange="this.form.submit()">
                </div>
                <div class="filter-form d-flex  col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Sampai</label>
                    <input type="date" class="search-container h4 w-" name="search_tanggal_end"
                        value="{{ request('search_tanggal_end') }}" onchange="this.form.submit()">
                </div>
                <div class="filter-form d-flex  col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for=""></label>
                    <button type="submit" class="btn-search"><i class="fa-regular fa-magnifying-glass"></i></button>
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
                <div class="tabs">
                    <button class="tab-button " data-tab="done-table">Belum direspon</button>
                    <button class="tab-button" data-tab="pending">Pending</button>
                    <button class="tab-button" data-tab="done-list">Selesai</button>
                </div>

                <div class="tab-content" style="margin: 0;" id="done-table">
                    <div class="content-table-table ">
                        <table>
                            <thead class="h4 f-bolder">
                                <tr>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Keluhan</th>
                                    <th>Tanggal Kunjungan</th>
                                    {{-- @if (auth()->user()->hasRole('admin')) --}}
                                    <th>Aksi</th>
                                    {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if ($kunjungans->isEmpty())
                                    <tr>
                                        <td colspan="5" class="" style="text-align: center;">Tidak ada Data</td>
                                    </tr>
                                @else
                                    @foreach ($kunjungans as $kunjungan)
                                        <tr>
                                            <td>{{ $kunjungan->pasien->nama }}</td>
                                            <td>{{ $kunjungan->dokter->nama ?? 'Edit untuk menambahkan dokter' }}</td>
                                            <td>{{ $kunjungan->keluhan }}</td>
                                            <td class="truncate-tb">{{ $kunjungan->tanggal_kunjungan }}</td>

                                            <td class="action-icons">
                                                <button type="button"
                                                    style="border: none; outline: none; background: transparent;"
                                                    onclick="btnOpenDetailModal({{ $kunjungan->id }})">
                                                    <i class="fa-regular fa-eye h3 mr-1 main-color pointer"></i>
                                                </button>

                                                <script>
                                                    function btnOpenDetailModal(kunjunganId) {
                                                        var modal = document.getElementById('detailModal' + kunjunganId);
                                                        var modalInstance = new bootstrap.Modal(modal);
                                                        modalInstance.show();
                                                    }
                                                </script>
                                                {{-- @if ($kunjungan->rekamMedis()->doesntExist() && !$kunjungan->dokter_id) --}}
                                                {{-- @if (auth()->user()->hasRole('admin'))
                                                    @if ($kunjungan->rekamMedis()->doesntExist())
                                                        <button type="button"
                                                            style="border: none; outline: none; background: transparent;"
                                                            onclick="btnOpenEditModal({{ $kunjungan->id }})">
                                                            <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                                        </button>
                                                    @endif
                                                @endif --}}


                                                @if ($kunjungan->rekamMedis()->doesntExist() && $kunjungan->dokter_id)
                                                    <button type="button"
                                                        style="border: none; outline: none; background: transparent;"
                                                        onclick="btnOpenAddRekamMedisModal({{ $kunjungan->id }})">
                                                        <i
                                                            class="fa-regular fa-notes-medical h3 mr-1 main-color pointer"></i>
                                                    </button>
                                                @endif

                                                <script>
                                                    function btnOpenAddRekamMedisModal(kunjunganId) {
                                                        document.getElementById('kunjungan_id').value = kunjunganId; // Set kunjungan_id in the form
                                                        document.getElementById('myModalAddRekamMedis').style.display = "block"; // Show modal
                                                    }

                                                    function closeAddRekamMedisModal() {
                                                        document.getElementById('myModalAddRekamMedis').style.display = "none"; // Hide modal
                                                    }
                                                </script>

                                                {{-- iki modal tambah rekammedis --}}
                                                <div class="modal animate__fadeIn" id="myModalAddRekamMedis">
                                                    <div class="modal-content animate__animated animate__zoomIn">
                                                        <h2 class="h2 f-bolder">Tambah Rekam Medis</h2>
                                                        <form id="addRekamMedisForm"
                                                            action="{{ route('rekam_medis.store', $kunjungan->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="kunjungan_id" id="kunjungan_id">

                                                            <div class="my-2">
                                                                <label for="diagnosa" class="h4 f-bolder">Diagnosa</label>
                                                                <div class="my-1">
                                                                    <input type="text"
                                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                                        id="diagnosa" name="diagnosa" required>
                                                                </div>
                                                            </div>

                                                            <!-- Tindakan -->
                                                            <div class="my-2">
                                                                <label for="tindakan" class="h4 f-bolder">Tindakan</label>
                                                                <div class="my-1">
                                                                    <input type="text"
                                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                                        id="tindakan" name="tindakan" required>
                                                                </div>
                                                            </div>

                                                            <!-- Resep -->
                                                            <div class="my-2">
                                                                <label for="deskripsi" class="h4 f-bolder">Resep</label>
                                                                <div class="my-1">
                                                                    <textarea class="form h4 f-normal px-2 w-100 border-radius-1" id="deskripsi" name="deskripsi" rows="4"
                                                                        required></textarea>
                                                                </div>
                                                            </div>

                                                            <!-- Obat -->
                                                            <div class="my-2">
                                                                <label for="obat_id" class="h4 f-bolder">Obat</label>
                                                                <div class="my-1">
                                                                    <select name="obat_id[]" id="obat_id"
                                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                                        multiple>
                                                                        @foreach ($obats as $obat)
                                                                            <option value="{{ $obat->id }}"
                                                                                data-stok="{{ $obat->jumlah }}">
                                                                                {{ $obat->obat }} (Stok:
                                                                                {{ $obat->jumlah }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Jumlah Obat -->
                                                            <div id="medication-quantity-section" class="my-2"></div>

                                                            <!-- Peralatan -->
                                                            <div class="my-2">
                                                                <label for="peralatan_id"
                                                                    class="h4 f-bolder">Peralatan</label>
                                                                <div class="my-1">
                                                                    <select name="peralatan_id[]" id="peralatan_id"
                                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                                        multiple>
                                                                        @foreach ($peralatans as $peralatan)
                                                                            <option value="{{ $peralatan->id }}">
                                                                                {{ $peralatan->nama_peralatan }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Gambar -->
                                                            <div class="my-2">
                                                                <label for="images" class="h4 f-bolder">Gambar</label>
                                                                <div class="my-1">
                                                                    <input type="file"
                                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                                        id="images" name="images[]" multiple>
                                                                </div>
                                                            </div>

                                                            <button type="button" class=" btn-close red-hover"
                                                                onclick="closeAddRekamMedisModal()">Batal</button>
                                                            <button type="submit" class=" btn-add">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <form id="reject-form-{{ $kunjungan->id }}"
                                                    action="{{ route('kunjungan.reject', $kunjungan->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <!-- Menggunakan PATCH karena kita hanya memperbarui status -->
                                                </form>
                                                <button type="button"
                                                    style="background: transparent; outline: none; border: none"
                                                    onclick="confirmReject({{ $kunjungan->id }})">
                                                    <i class="fa-regular fa-ban delete h3 mr-1 red pointer"></i>
                                                </button>

                                                <script>
                                                    function confirmReject(id) {
                                                        Swal.fire({
                                                            title: 'Tolak Kunjungan ini?',
                                                            text: "Data kunjungan akan di kembalikan ke pasien.",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Ya, tolak!',
                                                            cancelButtonText: 'Batal'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Submit form to reject kunjungan
                                                                document.getElementById('reject-form-' + id).submit();
                                                            }
                                                        });
                                                    }
                                                </script>

                                            </td>
                                            {{-- @endif --}}
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container">
                        {{ $kunjungans->links('vendor.pagination.custom') }}
                    </div>
                </div>

                <div class="tab-content" style="margin: 0;" id="pending">
                    <div class="content-table-table ">
                        <table>
                            <thead class="h4 f-bolder">
                                <tr>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Keluhan</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pendingkunjungans->isEmpty())
                                    <td colspan="5" class="text-center" style="text-align: center;">Tidak ada Data
                                    </td>
                                @else
                                    @foreach ($pendingkunjungans as $kunjungan)
                                        <tr>
                                            <td>{{ $kunjungan->pasien->nama }}</td>
                                            <td>{{ $kunjungan->dokter->nama ?? 'Edit untuk menambahkan dokter' }}</td>
                                            <td>{{ $kunjungan->keluhan }}</td>
                                            <td class="truncate-tb">{{ $kunjungan->tanggal_kunjungan }}</td>
                                            <td>Menunggu pembayaran</td>
                                            <td class="action-icons">
                                                <a href="{{ route('pendingdetails', $kunjungan->id) }}"><i
                                                        class="fa-regular fa-eye h3 mr-1 main-color pointer"></i></a>
                                                {{-- <form id="delete-form-{{ $kunjungan->id }}"
                                                    action="{{ route('kunjungan.updateStatus', $kunjungan->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <button type="submit"
                                                        style="background: transparent; outline: none; border: none"
                                                        onclick="confirmTransaction({{ $kunjungan->id }})">
                                                        <i class="fa-regular fa-badge-check h3 mr-1 success pointer"></i>
                                                    </button>
                                                    <script>
                                                        function confirmTransaction(id) {
                                                            Swal.fire({
                                                                title: 'Apakah Anda yakin?',
                                                                text: "Tandai pembayaran selesai?",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Ya, Selesaikan!',
                                                                cancelButtonText: 'Batal'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    document.getElementById('delete-form-' + id).submit();
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                @endif --}}
                                            </td>
                                            {{-- @endif --}}
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container">
                        {{ $pendingkunjungans->links('vendor.pagination.custom') }}
                    </div>
                </div>

                <div class="tab-content" style="margin: 0;" id="done-list">
                    <div class="content-table-table">
                        <div class="content-list">
                            @foreach ($donekunjungans as $kunjungan)
                                <div class="list-item">
                                    <!-- Atas -->
                                    <div class="top">
                                        <strong>Pasien :</strong> <span>{{ $kunjungan->pasien->nama }}</span>
                                    </div>
                                    <div class="top">
                                        <strong>Keluhan :</strong> <span class="truncate">{{ $kunjungan->keluhan }}</span>
                                    </div>

                                    <!-- Bawah -->
                                    <div class="bottom">
                                        <strong>Dokter :</strong>
                                        <span>{{ $kunjungan->dokter->nama ?? 'Belum ditentukan' }}</span>
                                    </div>
                                    <div class="bottom">
                                        <strong>Tanggal :</strong> <span>{{ $kunjungan->tanggal_kunjungan }}</span>
                                    </div>

                                    <div class="separator"></div>

                                    <!-- Tombol -->
                                    {{-- <a href="javascript:void(0)" class="btn-add" onclick="btnOpenDetailModal({{ $kunjungan->id }})">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a> --}}
                                    <a href="{{ route('kunjhistoryshow', $kunjungan->id) }}" class="btn-add"
                                        style="width: max-content">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <script>
                            function btnOpenDetailModal(kunjunganId) {
                                var modal = document.getElementById('detailModal' + kunjunganId);
                                var modalInstance = new bootstrap.Modal(modal);
                                modalInstance.show();
                            }
                        </script>
                    </div>
                    <div class="pagination-container">
                        {{ $donekunjungans->links('vendor.pagination.custom') }}
                    </div>
                </div>

                {{-- acc atau tambah dokter --}}
                @foreach ($kunjungans as $kunjungan)
                    <div class="modal" id="detailModal{{ $kunjungan->id }}" tabindex="-1"
                        aria-labelledby="detailModalLabel{{ $kunjungan->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modaldetail-content p-2 shadow-none animate__animated animate__zoomIn">
                                <!-- Hapus shadow -->
                                <div class="modal-header d-flex t-center a-center">
                                    <span class="square"
                                        style="width: 25px; height: 25px; background: #ccc; margin-right: 10px;"></span>
                                    <h2 class="modal-title h2 f-bolder" id="detailModalLabel{{ $kunjungan->id }}">
                                        Detail Kunjungan dan Rekam Medis
                                    </h2>
                                </div>
                                <form action="{{ route('kunjungan.update', $kunjungan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">
                                        <p class="h4 my-2"><strong>Pasien:</strong><br>
                                            {{ $kunjungan->pasien->nama }}
                                        </p>
                                        <p class="h4 my-2"><strong>Keluhan:</strong><br>
                                            {{ $kunjungan->keluhan }}</p>
                                        {{-- <p class="h4 my-1"><strong>Dokter:</strong>
                                            {{ $kunjungan->dokter->nama ?? 'Belum ditentukan' }}
                                        </p> --}}
                                        <p class="h4 my-1"><strong>Tanggal Kunjungan:</strong>
                                            {{ $kunjungan->tanggal_kunjungan }}</p>
                                        <hr class="my-2">

                                        {{-- <div class="my-2"> --}}
                                        {{-- <label for="pasien" class="h4 f-bolder">Pasien</label> --}}
                                        {{-- <div class="my-1"> --}}
                                        {{-- <select disabled name="pasien_id" id="pasien_id"
                                                    class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                                    <option value="{{ $kunjungan->pasien_id }}" selected>
                                                        {{ $kunjungan->pasien->nama }}
                                                    </option>
                                                    @foreach ($pasiens as $pas)
                                                        @if ($pas->id !== $kunjungan->pasien_id)
                                                            <option value="{{ $pas->id }}"
                                                                {{ $kunjungan->pasien_id == $pas->id ? 'selected' : '' }}>
                                                                {{ $pas->nama }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select> --}}
                                        <input type="hidden" name="pasien_id" value="{{ $kunjungan->pasien_id }}">
                                        {{-- </div> --}}
                                        {{-- </div> --}}
                                        @if (auth()->user()->hasRole('admin'))
                                        <div class="my-2">
                                            <label for="dokter" class="h4 f-bolder">Dokter</label>
                                            <div class="my-1">
                                                <select name="dokter_id" id="dokter_id" class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                                    <!-- Opsi default Pilih Dokter -->
                                                    <option value="" {{ empty($kunjungan->dokter_id) ? 'selected' : '' }}>Pilih Dokter</option>
                                    
                                                    <!-- Looping daftar dokter, memisahkan yang memiliki jadwal dan tidak -->
                                                    @php
                                                        // Pisahkan dokter yang memiliki jadwal dan yang tidak
                                                        $doktersWithSchedule = [];
                                                        $doktersWithoutSchedule = [];
                                                        
                                                        foreach ($dokters as $dok) {
                                                            $hariKunjungan = \Carbon\Carbon::parse($kunjungan->tanggal)->format('l'); // Format hari
                                    
                                                            // Mengecek apakah dokter memiliki jadwal pada hari tersebut
                                                            $hasSchedule = $dok->jadwals->where('hari', $hariKunjungan)->isNotEmpty();
                                                            
                                                            if ($hasSchedule) {
                                                                $doktersWithSchedule[] = $dok;
                                                            } else {
                                                                $doktersWithoutSchedule[] = $dok;
                                                            }
                                                        }
                                                    @endphp
                                    
                                                    <!-- Tampilkan dokter yang memiliki jadwal terlebih dahulu -->
                                                    @foreach ($doktersWithSchedule as $dok)
                                                        <option value="{{ $dok->id }}"
                                                            {{ isset($kunjungan->dokter_id) && $kunjungan->dokter_id == $dok->id ? 'selected' : '' }}>
                                                            {{ $dok->nama }} - {{ $dok->spesialis }}
                                                        </option>
                                                    @endforeach
                                    
                                                    <!-- Tampilkan dokter yang tidak memiliki jadwal di bawah -->
                                                    @foreach ($doktersWithoutSchedule as $dok)
                                                        <option value="{{ $dok->id }}"
                                                            {{ isset($kunjungan->dokter_id) && $kunjungan->dokter_id == $dok->id ? 'selected' : '' }} disabled>
                                                            {{ $dok->nama }} - {{ $dok->spesialis }} (Tidak Ada Jadwal)
                                                        </option>
                                                    @endforeach
                                    
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Jika pengguna bukan admin, dokter_id otomatis mengikuti dokter yang sedang login --}}
                                        <input type="hidden" name="dokter_id" value="{{ auth()->user()->dokter->id }}">
                                        <div class="my-2">
                                            <label class="h4 f-bolder">Dokter</label>
                                            <p class="h4 f-normal mt-1">{{ auth()->user()->dokter->nama }}</p>
                                        </div>
                                    @endif
                                    

                                        <div class="my-2">
                                            {{-- <label for="keluhan" class="h4 f-bolder">Keluhan</label> --}}
                                            <div class="my-1">
                                                <input type="hidden"
                                                    class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="keluhan"
                                                    name="keluhan" value="{{ $kunjungan->keluhan }}">
                                            </div>
                                            @error('keluhan')
                                                <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="my-2">
                                            {{-- <label for="tanggal_kunjungan" class="h4 f-bolder">Tanggal Kunjungan</label> --}}
                                            <div class="my-1">
                                                <input type="hidden"
                                                    class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                    id="tanggal_kunjungan" name="tanggal_kunjungan"
                                                    value="{{ $kunjungan->tanggal_kunjungan }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class=" btn-close red-hover"
                                            data-bs-dismiss="modal">Tutup</button>
                                        @if (auth()->user()->hasRole('admin'))
                                            <button type="submit" class="btn-add">
                                                {{ isset($kunjungan->dokter_id) ? 'Update' : 'Terima' }}
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal" id="pendingdetailModal{{ $kunjungan->id }}" tabindex="-1"
                        aria-labelledby="detailModalLabel{{ $kunjungan->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modaldetail-content p-2 shadow-none animate__animated animate__zoomIn">
                                <div class="modal-header d-flex t-center a-center">
                                    <span class="square"
                                        style="width: 25px; height: 25px; background: #ccc; margin-right: 10px;"></span>
                                    <h2 class="modal-title h2 f-bolder" id="detailModalLabel{{ $kunjungan->id }}">
                                        Detail Kunjungan dan Rekam Medis
                                    </h2>
                                </div>
                                <div class="modal-body">
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

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class=" btn-close red-hover"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let tabButtons = document.querySelectorAll(".tab-button");
                let tabContents = document.querySelectorAll(".tab-content");
                let defaultTab = "done-table"; // Default tab
                let savedTab = localStorage.getItem("activeTab");

                let activeTab = savedTab ? savedTab : defaultTab;
                document.querySelector(`[data-tab='${activeTab}']`).classList.add("active");
                document.getElementById(activeTab).classList.add("active");

                tabButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        let selectedTab = this.dataset.tab;

                        tabButtons.forEach(btn => btn.classList.remove("active"));
                        tabContents.forEach(content => content.classList.remove("active"));

                        this.classList.add("active");
                        document.getElementById(selectedTab).classList.add("active");

                        localStorage.setItem("activeTab", selectedTab);
                    });
                });

                document.getElementById("searchInput").addEventListener("keyup", function() {
                    let value = this.value.toLowerCase();
                    let activeTab = document.querySelector(".tab-content.active").id;

                    if (activeTab === "done-table") {
                        filterTable("doneTable", value);
                    } else if (activeTab === "pending") {
                        filterTable("pendingTable", value);
                    } else if (activeTab === "done-list") {
                        filterList("doneList", value);
                    }
                });

                function filterTable(tableId, value) {
                    let rows = document.getElementById(tableId).getElementsByTagName("tr");
                    for (let row of rows) {
                        let text = row.textContent.toLowerCase();
                        row.style.display = text.includes(value) ? "" : "none";
                    }
                }

                function filterList(listId, value) {
                    let items = document.getElementById(listId).getElementsByTagName("li");
                    for (let item of items) {
                        let text = item.textContent.toLowerCase();
                        item.style.display = text.includes(value) ? "" : "none";
                    }
                }
            });
        </script>
        <script>
            function showContent(id) {
                document.querySelectorAll('.content').forEach((el) => el.classList.remove('active'));

                document.getElementById(id).classList.add('active');

                document.querySelectorAll('.tab').forEach((el) => el.classList.remove('active'));
                event.currentTarget.classList.add('active');
            }
        </script>

        <script>
            document.getElementById('obat_id').addEventListener('change', function() {
                var selectedObats = Array.from(this.selectedOptions);
                var quantitySection = document.getElementById('medication-quantity-section');
                quantitySection.innerHTML = ''; // Clear previous inputs to avoid duplication

                selectedObats.forEach(function(obat) {
                    var stok = obat.getAttribute('data-stok');
                    var obatId = obat.value;

                    var inputGroup = document.createElement('div');
                    inputGroup.classList.add('mb-3', 'row');

                    var label = document.createElement('label');
                    label.classList.add('h4', 'f-bolder');
                    label.textContent = 'Jumlah (' + obat.textContent + ')';
                    inputGroup.appendChild(label);

                    var inputContainer = document.createElement('div');
                    inputContainer.classList.add('col-sm-12');

                    var input = document.createElement('input');
                    input.type = 'number';
                    input.name = 'jumlah_obat[]';
                    input.classList.add('form', 'h4', 'f-normal', 'px-2', 'w-100', 'h-3', 'border-radius-1');
                    input.placeholder = 'Jumlah';
                    input.min = 1;
                    input.max = stok;
                    input.required = true;

                    inputContainer.appendChild(input);
                    inputGroup.appendChild(inputContainer);
                    quantitySection.appendChild(inputGroup);
                });
            });
        </script>

        <div class="modal animate__fadeIn" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                @if (auth()->user()->hasRole('admin'))
                    <h2 class="h2 f-bolder">Tambah Kunjungan</h2>
                @endif

                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="pasien_id" class="h4 f-bolder">Pasien</label>
                        <div class="my-1">
                            <select name="pasien_id" id="pasien_id"
                                class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                <option>--- Pilih Pasien ---</option>
                                @foreach ($pasiens as $pas)
                                    <option value="{{ $pas->id }}">{{ $pas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('pasien_id')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    @if (auth()->user()->hasRole('admin'))
                        <div class="my-2">
                            <label for="dokter_id" class="h4 f-bolder">Dokter</label>
                            <div class="my-1">
                                <select name="dokter_id" id="dokter_id"
                                    class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                    <option>--- Pilih Dokter ---</option>
                                    @foreach ($dokters as $dok)
                                        <option value="{{ $dok->id }}">{{ $dok->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('dokter_id')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="my-2">
                        <label for="keluhan" class="h4 f-bolder">Keluhan</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="keluhan"
                                name="keluhan" value="{{ old('keluhan') }}">
                        </div>
                        @error('keluhan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="tanggal_kunjungan" class="h4 f-bolder">Tanggal Kunjungan</label>
                        <div class="my-1">
                            <input type="date" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                id="tanggal_kunjungan" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}">
                        </div>
                        @error('tanggal_kunjungan')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" class=" btn-close red-hover"
                        onclick="btnCloseAddKunjunganModal()">Batal</button>
                    <button type="submit" class=" btn-add">Simpan</button>
                </form>
            </div>
        </div>

        @foreach ($kunjungans as $kunjungan)
            {{-- iki detail modal --}}
            <div class="modal" id="detailModal{{ $kunjungan->id }}" tabindex="-1"
                aria-labelledby="detailModalLabel{{ $kunjungan->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modaldetail-content p-2 shadow-none animate__animated animate__zoomIn">
                        <!-- Hapus shadow -->
                        <div class="modal-header d-flex t-center a-center">
                            <span class="square"
                                style="width: 50px; height: 50px; background: #ccc; margin-right: 10px;"></span>
                            <h2 class="modal-title h2 f-bolder" id="detailModalLabel{{ $kunjungan->id }}">
                                Detail Kunjungan dan Rekam Medis
                            </h2>
                        </div>
                        <div class="modal-body">
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
                            <h2 class="h2 f-bolder">Detail Rekam Medis:</h2>
                            @if ($kunjungan->rekamMedis && $kunjungan->rekamMedis->count() > 0)
                                @foreach ($kunjungan->rekamMedis as $rekamMedis)
                                    <p class="h4 my-1"><strong>Diagnosa:</strong>
                                        {{ $rekamMedis->diagnosa }}</p>
                                    <p class="h4 my-1"><strong>Tindakan:</strong>
                                        {{ $rekamMedis->tindakan }}</p>
                                    <p class="h4 my-1"><strong>Obat:</strong></p>
                                    @if ($rekamMedis->obats && $rekamMedis->obats->count() > 0)
                                        @foreach ($rekamMedis->obats as $obat)
                                            <p>{{ $obat->obat }} - Jumlah:
                                                {{ $obat->pivot->jumlah }}</p>
                                        @endforeach
                                    @else
                                        <p>Tidak ada obat yang terkait</p>
                                    @endif
                                    <p class="h4 my-1"><strong>Resep:</strong>
                                        {{ $rekamMedis->resep->deskripsi ?? 'Tidak ada resep' }}
                                    </p>
                                    <p class="h4 my-1"><strong>Gambar:</strong></p>
                                    @foreach ($rekamMedis->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" height="150"
                                            width="120" class="mb-2" alt="Gambar">
                                    @endforeach
                                @endforeach
                            @else
                                <p class="h4 my-1">Tidak ada rekam medis untuk kunjungan
                                    ini.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class=" btn-close red-hover" data-bs-dismiss="modal">Tutup</button>
                            @if ($kunjungan->rekamMedis()->exists())
                                <a href="{{ route('rekam_medis.nota', $rekamMedis->id) }}" class="btn-cek-nota">
                                    Cek Nota
                                    <i class="fa-solid fa-print"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- iki modal edit kunjungan --}}
            <div class="modal animate__fadeIn" id="myModalEdit{{ $kunjungan->id }}">
                <div class="modal-content animate__animated animate__zoomIn">
                    <h2 class="h2 f-bolder">Edit Kunjungan</h2>
                    <form action="{{ route('kunjungan.update', $kunjungan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="my-2">
                            <label for="pasien" class="h4 f-bolder">Pasien</label>
                            <div class="my-1">
                                <select disabled name="pasien_id" id="pasien_id"
                                    class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                    <option value="{{ $kunjungan->pasien_id }}" selected>
                                        {{ $kunjungan->pasien->nama }}
                                    </option>
                                    @foreach ($pasiens as $pas)
                                        @if ($pas->id !== $kunjungan->pasien_id)
                                            <option value="{{ $pas->id }}"
                                                {{ $kunjungan->pasien_id == $pas->id ? 'selected' : '' }}>
                                                {{ $pas->nama }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="hidden" name="pasien_id" value="{{ $kunjungan->pasien_id }}">
                            </div>
                        </div>

                        @if (auth()->user()->hasRole('admin'))
                            <div class="my-2">
                                <label for="dokter" class="h4 f-bolder">Dokter</label>
                                <div class="my-1">
                                    <select name="dokter_id" id="dokter_id"
                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                        <option value="{{ $kunjungan->dokter_id ?? '' }}" selected>
                                            {{ $kunjungan->dokter->nama ?? 'Pilih Dokter' }}
                                        </option>
                                        @foreach ($dokters as $dok)
                                            @if ($dok->id !== $kunjungan->dokter_id)
                                                <option value="{{ $dok->id }}"
                                                    {{ $kunjungan->dokter_id == $dok->id ? 'selected' : '' }}>
                                                    {{ $dok->nama }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            {{-- Jika pengguna bukan admin, dokter_id otomatis mengikuti dokter yang sedang login --}}
                            <input type="hidden" name="dokter_id" value="{{ auth()->user()->dokter->id }}">
                            <div class="my-2">
                                <label class="h4 f-bolder">Dokter</label>
                                <p class="h4 f-normal mt-1">{{ auth()->user()->dokter->nama }}</p>
                            </div>
                        @endif


                        <div class="my-2">
                            <label for="keluhan" class="h4 f-bolder">Keluhan</label>
                            <div class="my-1">
                                <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="keluhan" name="keluhan" value="{{ $kunjungan->keluhan }}">
                            </div>
                            @error('keluhan')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="my-2">
                            <label for="tanggal_kunjungan" class="h4 f-bolder">Tanggal Kunjungan</label>
                            <div class="my-1">
                                <input type="date" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="tanggal_kunjungan" name="tanggal_kunjungan"
                                    value="{{ $kunjungan->tanggal_kunjungan }}" required>
                            </div>
                        </div>

                        <button type="button" class=" btn-close red-hover"
                            onclick="closeEditModal({{ $kunjungan->id }})">Batal</button>
                        <button type="submit" class=" btn-add">Simpan</button>
                    </form>
                </div>
            </div>
        @endforeach

        <script>
            var addModal = document.getElementById("myModalAdd");
            var btnOpenAddModal = document.getElementById("btnOpenAddModal");
            var btnCloseAddModal = document.getElementById("btnCloseAddModal");

            var editModal = document.getElementById("myModalEdit");
            var btnCloseEditModal = document.getElementById("btnCloseEditModal")

            btnOpenAddModal.onclick = function() {
                addModal.style.display = "block";
            }

            function btnCloseAddKunjunganModal() {
                var modal = document.getElementById("myModalAdd");
                modal.style.display = "none";
            }


            window.onclick = function(event) {
                if (event.target == modal) {
                    addModal.style.display = "none";
                }
            }

            function btnOpenEditModal(id) {
                var modal = document.getElementById("myModalEdit" + id);
                modal.style.display = "block";
            }

            function closeEditModal(id) {
                var modal = document.getElementById("myModalEdit" + id);
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                var modals = document.querySelectorAll('.modal');
                modals.forEach(function(modal) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                });
            }
        </script>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
