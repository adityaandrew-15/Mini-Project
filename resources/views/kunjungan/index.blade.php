@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="m-3">
        {{-- @if (auth()->user()->unreadNotifications->count())
    <div class="alert alert-info">
        Anda memiliki {{ auth()->user()->unreadNotifications->count() }} notifikasi baru!
        <a href="{{ route('notifikasi.index') }}">Lihat Notifikasi</a>
    </div>
    @endif --}}

        @if (session('success'))
            <script>
                Swal.fire('Success', '{{ session('success') }}', 'success');
            </script>
        @endif
        {{-- <div class="header">
            <input type="text" placeholder="Search"><i class="fa-solid fa-magnifying-glass" style="margin-left: -100px"></i>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div> --}}
        <div class="d-flex j-between m-2 a-center">
            <div class="d-flex a-center">
                <h2 class="h2 f-bolder mr-4">Data Kunjungan</h2>
                <div class="btn"></div>
                <button type="button" class="btn-add main-color-hover py-1 px-2" id="btnOpenAddModal">
                    Tambah Data Kunjungan
                </button>
            </div>
        </div>

        <div class="content-table m-2 d-flex col">
            <form method="GET" action="{{ route('kunjungan.index') }}" class="d-flex w-100 gap-2">

                <input type="text" class="search-container w-100 h4" name="search_pasien" placeholder="Cari Nama Pasien"
                    value="{{ request('search_pasien') }}" class="form-control">
                <input type="text" class="search-container w-100 h4" name="search_dokter" placeholder="Cari Nama Dokter"
                    value="{{ request('search_dokter') }}" class="form-control">
                    <input type="date" class="search-container w-40 h4" name="search_tanggal"
                    placeholder="Cari Nama atau No HP" value="{{ request('search_tanggal') }}" class="form-control" 
                    onchange="this.form.submit()">  
                    <button type="submit" class="btn btn-primary invisible-btn">Cari</button>

                    <style>
                        .invisible-btn {
                            opacity: 0;
                            /* Tombol tidak terlihat */
                            position: absolute;
                            /* Menghindari layout bergeser */
                            pointer-events: none;
                            /* Mencegah klik langsung */
                        }
                    </style>


            </form>

            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Keluhan</th>
                                <th>Tanggal Kunjungan</th>
                                @if (auth()->user()->hasRole('admin'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kunjungans as $kunjungan)
                                <tr>
                                    <td>{{ $kunjungan->pasien->nama }}</td>
                                    <td>{{ $kunjungan->dokter->nama ?? 'Edit untuk menambahkan dokter' }}</td>
                                    <td>{{ $kunjungan->keluhan }}</td>
                                    <td>{{ $kunjungan->tanggal_kunjungan }}</td>

                                    @if (auth()->user()->hasRole('admin'))
                                        <td class="action-icons">
                                            <button type="button"
                                                style="border: none; outline: none; background: transparent;"
                                                onclick="btnOpenEditModal({{ $kunjungan->id }})">
                                                <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                            </button>

                                            <form id="delete-form-{{ $kunjungan->id }}"
                                                action="{{ route('kunjungan.destroy', $kunjungan->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="submit"
                                                style="background: transparent; outline: none; border: none"
                                                onclick="confirmDelete({{ $kunjungan->id }})">
                                                <i class="fas fa-trash delete h3 mr-1 red pointer"></i>
                                            </button>
                                            <script>
                                                function confirmDelete(id) {
                                                    Swal.fire({
                                                        title: 'Apakah Anda yakin?',
                                                        text: "Data ini akan dihapus secara permanen!",
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
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal animate__fadeIn" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                @if (auth()->user()->hasRole('admin'))
                    <h2 class="h2 f-bolder">Tambah Kunjungan</h2>
                    <button type="button" class="btn-close" onclick="closeAddKunjunganModal()"></button>
                @endif

                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="pasien_id" class="h4 f-bolder">Pasien</label>
                        <div class="my-1">
                            <select name="pasien_id" id="pasien_id" class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
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

                    <button type="button" class="px-2 py-1 btn-close red-hover"
                        onclick="btnCloseAddKunjunganModal()">Batal</button>
                    <button type="submit" class="px-2 py-1 btn-add main-color-hover">Simpan</button>
                </form>
            </div>
        </div>

        @foreach ($kunjungans as $kunjungan)
            <div class="modal animate__fadeIn" id="myModalEdit{{ $kunjungan->id }}">
                <div class="modal-content animate__animated animate__zoomIn">
                    <h2 class="h2 f-bolder">Edit Kunjungan</h2>
                    <button type="button" class="btn-close" onclick="closeEditModal({{ $kunjungan->id }})"></button>

                    <form action="{{ route('kunjungan.update', $kunjungan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="my-2">
                            <label for="pasien" class="h4 f-bolder">Pasien</label>
                            <div class="my-1">
                                <select name="pasien_id" id="pasien_id"
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

                        <button type="button" class="px-2 py-1 btn-close red-hover"
                            onclick="closeEditModal({{ $kunjungan->id }})">Batal</button>
                        <button type="submit" class="px-2 py-1 btn-add main-color-hover">Simpan</button>
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
@endsection
