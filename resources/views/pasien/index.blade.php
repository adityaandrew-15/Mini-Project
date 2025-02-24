@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="ml-3 mr-3">
        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center mx-2">
                <h2 class="h2 f-bolder mr-4">Data Pasien</h2>
                <div class="btn"></div>
                <button type="button" class="btn-add main-color-hover" id="btnOpenAddModal">
                    Tambah Pasien
                </button>
            </div>
        </div>
        <hr class="mr-3 ml-3">
        <div class="modal animate__animated" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                <h2 class="h2 f-bolder">Tambah Pasien</h2>
                <form action="{{ route('pasien.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="nama" class="h4 f-bolder">Nama</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="nama"
                                name="nama" value="{{ old('nama') }}" required>
                        </div>
                        @error('nama')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="alamat" class="h4 f-bolder">Alamat</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="alamat"
                                name="alamat" value="{{ old('alamat') }}">
                        </div>
                        @error('alamat')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="no_hp" class="h4 f-bolder">No HP</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="no_hp"
                                name="no_hp" value="{{ old('no_hp') }}">
                        </div>
                        @error('no_hp')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="tanggal_lahir" class="h4 f-bolder">Tanggal Lahir</label>
                        <div class="my-1">
                            <input type="date" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="tanggal_lahir"
                                name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        </div>
                        @error('tanggal_lahir')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" id="btnCloseAddModal" class="btn-close red-hover">Batal</button>
                    <button type="submit" id="btnCloseAddModal" class="btn-add main-color-hover">Simpan</button>
                </form>
            </div>
        </div>

        <div class="content-table m-2 d-flex col">
            <div class="filter-form d-flex">
                <div class="d-flex col mr-1 w-100">
                    <label for="searchPasien"
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        class="label-text">Nama Pasien</label>
                    <input type="text" id="searchPasien" class="search-container w-100 h4" placeholder="Cari pasien...">
                </div>
                <div class="filter-form d-flex  col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for=""></label>
                    <button type="submit" class="btn-search"><i class="fa-regular fa-magnifying-glass"></i></button>
                </div>
            </div>
            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>No HP</th> <!-- Add column for phone number -->
                                @if (auth()->user()->hasRole('admin'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pasiens as $pasien)
                                <tr>
                                    <td>{{ $pasien->nama }}</td>
                                    <td>{{ $pasien->tanggal_lahir }}</td>
                                    <td>{{ $pasien->alamat }}</td>
                                    <td>{{ $pasien->no_hp }}</td> <!-- Add phone number column -->

                                    @if (auth()->user()->hasRole('admin'))
                                        <td class="action-icons">
                                            <button type="button"
                                                style="border: none; outline: none; background: transparent;"
                                                onclick="btnOpenDetailModal({{ $pasien->id }})">
                                                <i class="fas fa-info-circle detail h3 mr-1 pointer"></i>
                                            </button>
                                            <button type="button"
                                                style="border: none; outline: none; background: transparent;"
                                                onclick="btnOpenEditModal({{ $pasien->id }})">
                                                <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                            </button>
                                            <form id="delete-form-{{ $pasien->id }}"
                                                action="{{ route('pasien.destroy', $pasien->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="submit"
                                                style="background: transparent; outline: none; border: none"
                                                onclick="confirmDelete({{ $pasien->id }})">
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
                                                            document.getElementById('delete-form-' + id).submit();
                                                        }
                                                    });
                                                }
                                            </script>
                                        </td>
                                    @endif
                                </tr>

                                <div class="modal animate__fadeIn" id="myModalEdit{{ $pasien->id }}">
                                    <div class="modal-content animate__animated animate__zoomIn">
                                        <h2 class="h2 f-bolder">Edit Pasien</h2>
                                        <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="my-2">
                                                <label for="inputNama" class="h4 f-bolder">Nama</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="namaEdit{{ $pasien->id }}" name="nama"
                                                        value="{{ $pasien->nama }}">
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="inputAlamat" class="h4 f-bolder">Alamat</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="alamatEdit{{ $pasien->id }}" name="alamat"
                                                        value="{{ $pasien->alamat }}">
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="inputNo_hp" class="h4 f-bolder">No HP</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="no_hpEdit{{ $pasien->id }}" name="no_hp"
                                                        value="{{ $pasien->no_hp }}">
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="inputTanggalLahir" class="h4 f-bolder">Tanggal Lahir</label>
                                                <div class="my-1">
                                                    <input type="date"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="tanggal_lahirEdit{{ $pasien->id }}" name="tanggal_lahir"
                                                        value="{{ $pasien->tanggal_lahir }}">
                                                </div>
                                            </div>
                                            <hr>
                                            <h5>Input Kunjungan</h5>
                                            <div class="my-2">
                                                <label for="inputDokter" class="h4 f-bolder">Dokter</label>
                                                <div class="my-1">
                                                    <select class="form-select h4 f-normal w-100"
                                                        id="dokter_idEdit{{ $pasien->id }}" name="dokter_id" required>
                                                        <option value="">Pilih Dokter</option>
                                                        @foreach ($dokters as $dokter)
                                                            <option value="{{ $dokter->id }}"
                                                                {{ $pasien->dokter_id == $dokter->id ? 'selected' : '' }}>
                                                                {{ $dokter->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="inputKeluhan" class="h4 f-bolder">Keluhan</label>
                                                <div class="my-1">
                                                    <textarea class="form h4 f-normal px-2 w-100" id="keluhanEdit{{ $pasien->id }}" name="keluhan" rows="3">{{ $pasien->keluhan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="inputTanggalKunjungan" class="h4 f-bolder">Tanggal
                                                    Kunjungan</label>
                                                <div class="my-1">
                                                    <input type="date"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="tanggal_kunjunganEdit{{ $pasien->id }}"
                                                        name="tanggal_kunjungan"
                                                        value="{{ $pasien->tanggal_kunjungan }}">
                                                </div>
                                            </div>

                                            <button type="button" class="btn-close red-hover"
                                                onclick="closeEditModal({{ $pasien->id }})">Batal</button>
                                            <button type="submit" class="btn-add main-color-hover">Simpan</button>
                                        </form>
                                    </div>
                                </div>


                                <div class="modal animate__fadeIn" id="myModalDetail{{ $pasien->id }}">
                                    <div class="modal-content animate__animated animate__zoomIn">
                                        <h2 class="h2 f-bolder">Detail Pasien: {{ $pasien->nama }}</h2>
                                        <div class="modal-body">
                                            <p class="h4 my-1"><strong>Nama:</strong> {{ $pasien->nama }}</p>
                                            <p class="h4 my-1"><strong>Alamat:</strong> {{ $pasien->alamat ?: 'kosong' }}
                                            </p>
                                            <p class="h4 my-1"><strong>No HP:</strong> {{ $pasien->no_hp ?: 'kosong' }}
                                            </p>
                                            <p class="h4 my-1"><strong>Tanggal Lahir:</strong>
                                                {{ $pasien->tanggal_lahir ?: 'kosong' }}</p>
                                            <hr class="my-1">
                                            <button type="button" class="btn-close"
                                                onclick="closeDetailModal({{ $pasien->id }})">Close</button>
                                        </div>
                                    </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container">
                    {{ $pasiens->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>

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
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif
    <script>
        var addModal = document.getElementById("myModalAdd");
        var btnOpenAddModal = document.getElementById("btnOpenAddModal");
        var btnCloseAddModal = document.getElementById("btnCloseAddModal");

        var editModal = document.getElementById("myModalEdit");

        var detailModal = document.getElementById("myModalDetail");

        btnOpenAddModal.onclick = function() {
            addModal.style.display = "block";
        }

        btnCloseAddModal.onclick = function() {
            addModal.style.display = "none";
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

        function closeDetailModal(id) {
            var modal = document.getElementById("myModalDetail" + id);
            modal.style.display = "none";
        }

        function btnOpenDetailModal(id) {
            var modal = document.getElementById("myModalDetail" + id);
            modal.style.display = "block";
        }

        window.onclick = function(event) {
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let searchInput = document.getElementById("searchPasien");
            let clearButton = document.getElementById("clearSearch");
            let tableBody = document.querySelector("tbody");

            searchInput.addEventListener("input", filterTable);
            clearButton.addEventListener("click", function() {
                searchInput.value = "";
                filterTable();
            });

            function filterTable() {
                let query = searchInput.value.toLowerCase();
                let rows = tableBody.querySelectorAll("tr");

                rows.forEach(row => {
                    let pasienName = row.children[0].textContent.toLowerCase();
                    row.style.display = pasienName.includes(query) ? "" : "none";
                });
            }
        });
    </script>
@endsection
