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
                <h2 class="h2 f-bolder mr-4">Data Dokter</h2>
                <div class="btn"></div>
                @if (auth()->user()->hasRole('admin'))
                    <button type="button" class="btn-add main-color-hover py-1 px-2" id="btnOpenAddModal">
                        Tambah Dokter
                    </button>
                @endif
            </div>
            <h2>Dokter aktif: 9090</h2>
        </div>

        <!-- Keluar button -->
        {{-- <button class="btn btn-danger">
    <i class="fas fa-sign-out-alt"></i> Keluar
</button> --}}

        <div class="content-table m-2 d-flex col">
            {{-- @if (auth()->user()->hasRole('admin'))
        <button type="button" class="add-button" data-bs-toggle="modal" data-bs-target="#addModal">
            + Tambah Dokter
        </button>
    @endif --}}
            <form method="GET" action="{{ route('dokter.index') }}">
                <!-- Search input with magnifying glass icon inside the button -->
                <input type="text" class="search-container w-100 h4" name="search" placeholder="Search"
                    value="{{ request('search') }}" class="form-control">
                {{-- <button type="submit" class="btn btn-link">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button> --}}
            </form>
            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Spesialis</th>
                                <th>No HP</th>
                                {{-- <th>Image</th> --}}
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
                                            <img src="{{ asset('storage/dokters/' . $dokter->image) }}" height="100px"
                                                width="80px" alt="gambar">
                                        @else
                                            <img class="table-img" src="{{ asset('asset/img/dokter.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $dokter->nama }}</td>
                                    <td>{{ $dokter->spesialis }}</td>
                                    <td>{{ $dokter->no_hp }}</td>
                                    {{-- <td>
                                        @if ($dokter->image)
                                            <img src="{{ asset('storage/dokters/' . $dokter->image) }}" height="100px"
                                                width="80px" alt="gambar">
                                        @else
                                            <p>Kosong</p>
                                        @endif
                                    </td> --}}

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
                                                            // Submit form hapus
                                                            document.getElementById('delete-form-' + id).submit();
                                                        }
                                                    });
                                                }
                                            </script>
                                        </td>
                                    @endif
                                </tr>

                                <!-- Modal Edit Dokter -->
                                <div class="modal animate__fadeIn" id="myModalEdit{{ $dokter->id }}">
                                    <div class="modal-content animate__animated animate__zoomIn">
                                        <h2 class="h2 f-bolder">Edit Dokter</h2>
                                        <button type="button" class="btn-close"
                                            onclick="closeEditModal({{ $dokter->id }})"></button>
                                        <form action="{{ route('dokter.update', $dokter->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="my-2">
                                                <label for="inputNama" class="h4 f-bolder">Nama</label>
                                                <div class="my-1">
                                                    <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="namaEdit{{ $dokter->id }}" name="nama"
                                                        value="{{ $dokter->nama }}">
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="inputSpesialis" class="h4 f-bolder">Spesialis</label>
                                                <div class="my-1">
                                                    <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="spesialisEdit{{ $dokter->id }}" name="spesialis"
                                                        value="{{ $dokter->spesialis }}">
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="inputNo_hp" class="h4 f-bolder">No HP</label>
                                                <div class="my-1">
                                                    <input type="number" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="no_hpEdit{{ $dokter->id }}" name="no_hp"
                                                        value="{{ $dokter->no_hp }}">
                                                </div>
                                            </div>
                                            <div class="my-2">
                                                <label for="image" class="h4 f-bolder">Image</label>
                                                <div class="my-1">
                                                    <input type="file" class="h4 f-bolder px-2 w-100 h-3"
                                                        id="imageEdit{{ $dokter->id }}" name="image">
                                                </div>
                                                @if ($dokter->image)
                                                    <img src="{{ asset('storage/dokters/' . $dokter->image) }}"
                                                        class="mt-2" width="100">
                                                @endif
                                            </div>

                                            <button type="button" class="px-2 py-1 btn-close red-hover"
                                                onclick="closeEditModal({{ $dokter->id }})">Close</button>
                                            <button type="submit" class="px-2 py-1 btn-add main-color-hover">Save</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Dokter -->
        <div class="modal animate__animated" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                <h2 class="h2 f-bolder">Tambah Dokter</h2>
                <button type="button" class="btn-close"></button>
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
                        <label for="inputSpesialis" class="h4 f-bolder">Spesialis</label>
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
                    <!-- Add this inside the form for creating a doctor -->
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
                            <input type="file" class="h4 f-bolder px-2 w-100 h-3" id="image"
                                name="image">
                        </div>
                    </div>

                    <button type="button" id="btnCloseAddModal" class="px-2 py-1 btn-close red-hover">Close</button>
                    <button type="submit" id="btnCloseAddModal" class="px-2 py-1 btn-add main-color-hover">Save</button>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
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

            // Fungsi untuk membuka modal edit dan mengisi data ke dalam form
            function btnOpenEditModal(id) {
                // Menampilkan modal edit berdasarkan id dokter
                var modal = document.getElementById("myModalEdit" + id);
                modal.style.display = "block";
            }

            // Fungsi untuk menutup modal edit
            function closeEditModal(id) {
                var modal = document.getElementById("myModalEdit" + id);
                modal.style.display = "none";
            }

            // Menutup modal jika pengguna mengklik di luar modal
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
