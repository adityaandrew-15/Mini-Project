@extends('layouts.sidebar')
<style></style>
@section('side')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Pasien</title>
    </head>

    <body>

        <div class="m-3">
            <div class="d-flex j-between m-2 a-center">
                <div class="d-flex a-center">
                    <h2 class="h2 f-bolder mr-4">Peralatan Medis</h2>
                    <div class="btn"></div>
                    <button type="button" class="btn-add main-color-hover py-1 px-2" id="btnOpenAddModal">
                        Tambah peralatan
                    </button>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal animate__animated" id="myModalAdd" tabindex="-1" aria-labelledby="addModalLabel"
                aria-hidden="true">
                <div class="modal-content animate__animated animate__zoomIn">
                    <h2 class="h2 f-bolder">Tambah Peralatan</h2>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    <form action="{{ route('peralatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-2">
                            <label for="nama_peralatan" class="h4 f-bolder">Nama Peralatan</label>
                            <div class="my-1">
                                <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="nama_peralatan" name="nama_peralatan" value="{{ old('nama_peralatan') }}" required>
                            </div>
                            @error('nama_peralatan')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="my-2">
                            <label for="harga" class="h4 f-bolder">Harga</label>
                            <div class="my-1">
                                <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="harga"
                                    name="harga" value="{{ old('harga') }}" required>
                            </div>
                            @error('harga')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="my-2">
                            <label for="gambar" class="h4 f-bolder">Image</label>
                            <div class="my-1">
                                <input type="file" class="h4 f-bolder px-2 w-100 h-3" id="gambar" name="gambar">
                            </div>
                        </div>

                        <button type="button" class="px-2 py-1 btn-close red-hover" id="btnCloseAddModal">Batal</button>
                        <button type="submit" class="px-2 py-1 btn-add main-color-hover">Simpan</button>
                    </form>
                </div>
            </div>


            <!-- Table -->
            <div class="content-table m-2 d-flex col">
                <form action="{{ route('peralatan.index') }}" method="GET" class="d-flex w-100 gap-2">
                    <!-- Search Nama Peralatan -->
                    <input type="text" class="search-container w-75 h4" name="search" placeholder="Cari Nama Peralatan"
                        value="{{ request('search') }}" class="form-control">

                    <div class="filter-form d-flex">
                        <!-- Search Harga Minimal -->
                        <input type="number" class="search-container h4" style="width: 200px" name="min_price" placeholder="Harga Minimal"
                            value="{{ request('min_price') }}" class="form-control">

                        <!-- Search Harga Maksimal -->
                        <input type="number" class="search-container h4" style="width: 200px" name="max_price" placeholder="Harga Maksimal"
                            value="{{ request('max_price') }}" class="form-control">
                    </div>

                    <!-- Tombol Cari -->
                    <button type="submit" class="btn-filter">Cari</button>

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
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama peralatan</th>
                                    <th>gambar</th>
                                    <th>harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peralatan as $per)
                                    <tr>
                                        <td>{{ $per->nama_peralatan }}</td>
                                        <td>
                                            @if ($per->gambar)
                                                <img src="{{ asset('storage/peralatan/' . $per->gambar) }}" height="100"
                                                    width="80" alt="gambar">
                                            @else
                                                <img class="table-img" src="{{ asset('asset/img/peralatan.png') }}"
                                                    alt="gambar default">
                                            @endif
                                        </td>

                                        <td>Rp. {{ $per->harga }}</td>
                                        <td class="action-icons">

                                            <button type="button"
                                                style="border: none; outline: none; background: transparent;"
                                                onclick="btnOpenEditModal({{ $per->id }})">
                                                <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                            </button>
                                            <form id="delete-form-{{ $per->id }}"
                                                action="{{ route('peralatan.destroy', $per->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="submit"
                                                style="background: transparent; outline: none; border: none"
                                                onclick="confirmDelete({{ $per->id }})">
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
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal animate__fadeIn" id="myModalEdit{{ $per->id }}">
                                        <div class="modal-content animate__animated animate__zoomIn">
                                            <h2 class="h2 f-bolder">Edit Peralatan</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            <form action="{{ route('peralatan.update', $per->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="my-2">
                                                    <label for="nama_peralatan" class="h4 f-bolder">Nama Peralatan</label>
                                                    <div class="my-1">
                                                        <input type="text"
                                                            class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                            id="nama_peralatan" name="nama_peralatan"
                                                            value="{{ $per->nama_peralatan }}" required>
                                                    </div>
                                                </div>
                                                @error('nama_peralatan')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror

                                                <div class="my-2">
                                                    <label for="harga" class="h4 f-bolder">Harga</label>
                                                    <div class="my-1">
                                                        <input type="text"
                                                            class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                            id="harga" name="harga" value="{{ $per->harga }}"
                                                            required>
                                                    </div>
                                                </div>
                                                @error('harga')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror

                                                <div class="my-2">
                                                    <label for="gambar" class="h4 f-bolder">Image</label>
                                                    <div class="my-1">
                                                        <input type="file" class="h4 f-bolder px-2 w-100 h-3"
                                                            id="gambar" name="gambar">
                                                    </div>
                                                    @if ($per->gambar)
                                                        <div class="mt-2">
                                                            <p>Gambar Lama:</p>
                                                            <img src="{{ asset('storage/peralatan/' . $per->gambar) }}"
                                                                class="mt-2" width="500">
                                                        </div>
                                                    @endif
                                                </div>

                                                <button type="button" class="px-2 py-1 btn-close red-hover"
                                                    onclick="closeEditModal({{ $per->id }})">Batal</button>
                                                <button type="submit"
                                                    class="px-2 py-1 btn-add main-color-hover">Simpan</button>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Detail Modal for Visit and Medical Record Input -->
                                @endforeach
                            </tbody>
                        </table>
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


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            var addModal = document.getElementById("myModalAdd");
            var btnOpenAddModal = document.getElementById("btnOpenAddModal");
            var btnCloseAddModal = document.getElementById("btnCloseAddModal");

            var editModal = document.getElementById("myModalEdit");
            var btnCloseEditModal = document.getElementById("btnCloseEditModal")

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
        </script>
    </body>

    </html>
@endsection
