@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="ml-3 mr-3">
        <div class="d-flex j-between m-2 a-center">
            <div class="d-flex j-between w-100 a-center mx-2">
                <h2 class="h2 f-bolder mr-4">Data Dokter</h2>
                <div class="btn"></div>
                @if (auth()->user()->hasRole('admin'))
                    <button type="button" class="btn-add main-color-hover" id="btnOpenAddModal">
                        Tambah Dokter
                    </button>
                @endif
            </div>
        </div>
        <hr class="mr-3 ml-3">
        <div class="content-table m-2 d-flex col">
            <form method="GET" action="{{ route('dokter.index') }}" class="d-flex w-100 gap-2">
                <div class="d-flex w-100 col mr-1">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Nama
                        Dokter</label>
                    <input type="text" class="search-container w-100 h4" name="search"
                        placeholder="Cari Nama atau No HP" value="{{ request('search') }}" class="form-control">
                </div>
                <div class="d-flex w-100 col mr-1">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Spesialis</label>
                    <input type="text" class="search-container w-100 h4" name="spesialis" placeholder="Cari Spesialis"
                        value="{{ request('spesialis') }}" class="form-control">
                </div>
                <div class="filter-form d-flex col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for=""></label>
                    <button type="submit" class="btn-search"><i class="fa-regular fa-magnifying-glass"></i></button>
                </div>
            </form>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const searchInput = document.querySelector("input[name='search']");
                    const spesialisInput = document.querySelector("input[name='spesialis']");
                    const tableRows = document.querySelectorAll("tbody tr");

                    function filterTable() {
                        const searchText = searchInput.value.toLowerCase();
                        const spesialisText = spesialisInput.value.toLowerCase();

                        tableRows.forEach(row => {
                            const nama = row.children[1].textContent.toLowerCase();
                            const spesialis = row.children[2].textContent.toLowerCase();
                            const noHp = row.children[3].textContent.toLowerCase();

                            const matchSearch = nama.includes(searchText) || noHp.includes(searchText);
                            const matchSpesialis = spesialis.includes(spesialisText);

                            if (matchSearch && matchSpesialis) {
                                row.style.display = "table-row";
                            } else {
                                row.style.display = "none";
                            }
                        });
                    }

                    searchInput.addEventListener("keyup", filterTable);
                    spesialisInput.addEventListener("keyup", filterTable);
                });
            </script>
            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Spesialis</th>
                                <th>No HP</th>
                                @if (auth()->user()->hasRole('admin'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dokters as $dokter)
                                <tr>
                                    <td>
                                        @if ($dokter->image)
                                            <img class="table-img" src="{{ asset('storage/' . $dokter->image) }}"
                                                height="100px" width="100px" alt="gambar">
                                        @else
                                            <img class="table-img" src="{{ asset('asset/img/dokter.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $dokter->nama }}</td>
                                    <td>{{ $dokter->spesialis }}</td>
                                    <td>{{ $dokter->no_hp }}</td>

                                    @if (auth()->user()->hasRole('admin'))
                                        <td class="action-icons">
                                            <button type="button"
                                                style="border: none; outline: none; background: transparent;"
                                                onclick="btnOpenEditModal({{ $dokter->id }})">
                                                <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                            </button>
                                            <form id="delete-form-{{ $dokter->id }}"
                                                action="{{ route('dokter.destroy', $dokter->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="submit"
                                                style="background: transparent; outline: none; border: none"
                                                onclick="confirmDelete({{ $dokter->id }})">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container">
                    {{ $dokters->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>

        @foreach ($dokters as $dokter)
            <div class="modal animate__fadeIn" id="myModalEdit{{ $dokter->id }}">
                <div class="modal-content animate__animated animate__zoomIn">
                    <h2 class="h2 f-bolder">Edit Dokter</h2>
                    <form action="{{ route('dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="my-2">
                            <label for="inputNama" class="h4 f-bolder">Nama</label>
                            <div class="my-1">
                                <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="namaEdit{{ $dokter->id }}" name="nama" value="{{ $dokter->nama }}">
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="spesialis" class="h4 f-bolder">Spesialis</label>
                            <div class="my-1">
                                <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="spesialis{{ $dokter->id }}" name="spesialis" value="{{ $dokter->spesialis }}">
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="inputNo_hp" class="h4 f-bolder">No HP</label>
                            <div class="my-1">
                                <input type="number" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="no_hpEdit{{ $dokter->id }}" name="no_hp" value="{{ $dokter->no_hp }}">
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="image" class="h4 f-bolder">Image</label>
                            <div class="my-1">
                                <input type="file" class="h4 f-bolder px-2 w-100 h-3"
                                    id="imageEdit{{ $dokter->id }}" name="image">
                            </div>
                            @if ($dokter->image)
                                <img src="{{ asset('storage/' . $dokter->image) }}" class="mt-2" width="100">
                            @endif
                        </div>

                        <button type="button" class="btn-close red-hover"
                            onclick="closeEditModal({{ $dokter->id }})">Batal</button>
                        <button type="submit" class="btn-add main-color-hover">Simpan</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="modal animate__animated" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                <h2 class="h2 f-bolder">Tambah Dokter</h2>
                <form action="{{ route('dokter.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="my-2">
                        <label for="inputNama" class="h4 f-bolder">Nama</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="nama"
                                name="nama" value="{{ old('nama') }}">
                        </div>
                        @error('nama')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="spesialis" class="h4 f-bolder">Spesialis</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="spesialis"
                                name="spesialis" value="{{ old('spesialis') }}">
                        </div>
                        @error('spesialis')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="inputNo_hp" class="h4 f-bolder">No_hp</label>
                        <div class="my-1">
                            <input type="number" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="no_hp"
                                name="no_hp" value="{{ old('no_hp') }}">
                        </div>
                        @error('no_hp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="inputEmail" class="h4 f-bolder">Email</label>
                        <div class="my-1">
                            <input type="email" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="email"
                                name="email" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="inputPassword" class="h4 f-bolder">Password</label>
                        <div class="my-1">
                            <input type="password" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="password"
                                name="password" required>
                        </div>
                        @error('password')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="image" class="h4 f-bolder">Image</label>
                        <div class="my-1">
                            <input type="file" class="h4 f-bolder px-2 w-100 h-3" id="image" name="image">
                        </div>
                    </div>

                    <button type="button" id="btnCloseAddModal" class="btn-close red-hover">Batal</button>
                    <button type="submit" id="btnCloseAddModal" class="btn-add main-color-hover">Simpan</button>
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
