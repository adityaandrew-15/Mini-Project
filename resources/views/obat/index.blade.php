@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="m-3">
        @if (session('success'))
            <script>
                Swal.fire('Success', '{{ session('success') }}', 'success');
            </script>
        @endif

        <div class="d-flex j-between m-2 a-center">
            <div class="d-flex a-center">
                <h2 class="h2 f-bolder mr-4">Data Obat</h2>
                <div class="btn"></div>
                @if (auth()->user()->hasRole('admin'))
                    <button type="button" class="btn-add main-color-hover py-1 px-2" id="btnOpenAddModal">
                        Tambah Obat
                    </button>
                @endif
            </div>
        </div>
        <div class="content-table m-2 d-flex col">
            <form method="GET" action="{{ route('obat.index') }}">
                <input type="text" class="search-container w-100 h4" name="search" placeholder="Search"
                    value="{{ request('search') }}" class="form-control">
                <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}" class="form-control" style="width: 100px; display: inline-block;">
                <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}" class="form-control" style="width: 100px; display: inline-block;">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Obat</th>
                                <th>Jumlah</th>
                                <th>harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obats as $obt)
                                <tr>
                                    <td>{{ $obt->obat }}</td>
                                    <td>{{ $obt->jumlah }}</td>
                                    <td>Rp.{{ $obt->harga }}</td>
                                    <td class="action-icons">
                                        <button type="button" style="border: none; outline: none; background: transparent;"
                                            onclick="btnOpenEditModal({{ $obt->id }})">
                                            <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                        </button>
                                        <form id="delete-form-{{ $obt->id }}"
                                            action="{{ route('obat.destroy', $obt->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                style="background: transparent; outline: none; border: none"
                                                onclick="confirmDelete({{ $obt->id }})">
                                                <i class="fas fa-trash delete h3 mr-1 red pointer"></i>
                                            </button>
                                        </form>

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
                                </tr>
                                <div class="modal animate__fadeIn" id="myModalEdit{{ $obt->id }}">
                                    <div class="modal-content animate__animated animate__zoomIn">
                                        <h2 class="h2 f-bolder">Edit Obat</h2>
                                        <button type="button" class="btn-close"
                                            onclick="closeEditModal({{ $obt->id }})"></button>
                                        <form action="{{ route('obat.update', $obt->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="my-2">
                                                <label for="obat" class="h4 f-bolder">Obat</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="obat" name="obat" value="{{ $obt->obat }}">
                                                </div>
                                                @error('obat')
                                                    <script>
                                                        Swal.fire('Error', '{{ $message }}', 'error');
                                                    </script>
                                                @enderror
                                            </div>
                                            <div class="my-2">
                                                <label for="Jumlah" class="h4 f-bolder">Jumlah</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="jumlah" name="jumlah" value="{{ $obt->jumlah }}">
                                                </div>
                                                @error('jumlah')
                                                    <script>
                                                        Swal.fire('Error', '{{ $message }}', 'error');
                                                    </script>
                                                @enderror
                                            </div>
                                            <div class="my-2">
                                                <label for="harga" class="h4 f-bolder">Harga</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="harga" name="harga" value="{{ $obt->harga }}">
                                                </div>
                                                @error('harga')
                                                    <script>
                                                        Swal.fire('Error', '{{ $message }}', 'error');
                                                    </script>
                                                @enderror
                                            </div>
                                            <button type="button" class="px-2 py-1 btn-close red-hover"
                                                onclick="closeEditModal({{ $obt->id }})">Batal</button>
                                            <button type="submit"
                                                class="px-2 py-1 btn-add main-color-hover">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal animate__animated" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                <h2 class="h2 f-bolder">Tambah Obat</h2>
                <button type="button" class="btn-close"></button>
                <form action="{{ route('obat.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="obat" class="h4 f-bolder">Obat</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="obat"
                                name="obat" value="{{ old('obat') }}">
                        </div>
                        @error('obat')
                            <script>
                                Swal.fire('Error', '{{ $message }}', 'error');
                            </script>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="Jumlah" class="h4 f-bolder">Jumlah</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="jumlah"
                                name="jumlah" value="{{ old('jumlah') }}">
                        </div>
                        @error('jumlah')
                            <script>
                                Swal.fire('Error', '{{ $message }}', 'error');
                            </script>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="harga" class="h4 f-bolder">Harga</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="harga"
                                name="harga" value="{{ old('harga') }}">
                        </div>
                        @error('harga')
                            <script>
                                Swal.fire('Error', '{{ $message }}', 'error');
                            </script>
                        @enderror
                    </div>

                    <button type="button" id="btnCloseAddModal" class="px-2 py-1 btn-close red-hover">Batal</button>
                    <button type="submit" id="btnCloseAddModal"
                        class="px-2 py-1 btn-add main-color-hover">Simpan</button>
                </form>
            </div>
        </div>

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
    </div>
@endsection
