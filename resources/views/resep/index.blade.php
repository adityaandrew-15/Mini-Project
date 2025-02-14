@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="m-3">
        @if (session('success'))
            <script>
                Swal.fire('Success', '{{ session('success') }}', 'success');
            </script>
        @endif

        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center">
                <h2 class="h2 f-bolder mr-4">Data Resep</h2>
                <div class="btn"></div>
                @if (auth()->user()->hasRole('admin'))
                    <button type="button" class="btn-add main-color-hover" id="btnOpenAddModal">
                        Tambah Resep
                    </button>
                @endif
            </div>
        </div>
        {{-- <div class="row mb-3">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('resep.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari Resep..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            @if (request('search'))
                            <a href="{{ route('resep.index') }}" class="btn btn-outline-danger">Clear</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
        {{-- {{ $rekam->appends(['search' => request('search')])->links() }}         --}}
        <div class="modal animate__animated" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                <h2 class="h2 f-bolder">Tambah Resep</h2>
                <form action="{{ route('resep.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="kunjungan_id" class="h4 f-bolder">Pasien</label>
                        <div class="my-1">
                            <select name="kunjungan_id" id="kunjungan_id"
                                class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                <option>--- Pasien ---</option>
                                @foreach ($Rekmed as $rek)
                                    <option value="{{ $rek->id }}">{{ $rek->pasien->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('kunjungan_id')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="my-2">
                        <label for="deskripsi" class="h4 f-bolder">Deskripsi</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="deskripsi"
                                name="deskripsi" value="{{ old('deskripsi') }}">
                        </div>
                        @error('deskripsi')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="button" id="btnCloseAddModal" class="px-2 py-1 btn-close red-hover">Batal</button>
                    <button type="submit" class="px-2 py-1 btn-add main-color-hover">Simpan</button>
                </form>
            </div>
        </div>


        <div class="content-table m-2 d-flex col">
            <form method="GET" action="{{ route('resep.index') }}">
                <input type="text" class="search-container w-100 h4" name="search" placeholder="Search" value="{{ request('search') }}" class="form-control">
            </form>
        
            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Pasien</th>
                                <th>Deskripsi</th>
                                @if (auth()->user()->hasRole('admin'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reseps as $resep)
                                <tr>
                                    <td>{{ $resep->kunjungan->pasien->nama }}</td>
                                    <td>{{ $resep->deskripsi }}</td>
                                    @if (auth()->user()->hasRole('admin'))
                                        <td class="action-icons">
                                            <button type="button" style="border: none; outline: none; background: transparent;" onclick="btnOpenEditModal({{ $resep->id }})">
                                                <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                            </button>
        
                                            <form id="delete-form-{{ $resep->id }}" action="{{ route('resep.destroy', $resep->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="submit" style="background: transparent; outline: none; border: none" onclick="confirmDelete({{ $resep->id }})">
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
        
                                <div class="modal animate__animated" id="myModalEdit{{ $resep->id }}">
                                    <div class="modal-content animate__animated animate__zoomIn">
                                        <h2 class="h2 f-bolder">Edit Resep</h2>
                                        <button type="button" class="btn-close" onclick="closeEditModal({{ $resep->id }})"></button>
                                        <form action="{{ route('resep.update', $resep->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="my-2">
                                                <label for="kunjungan_id" class="h4 f-bolder">Pasien</label>
                                                <div class="my-1">
                                                    <select name="kunjungan_id" id="kunjungan_id" class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                                        <option value="{{ $resep->kunjungan_id }}" selected>
                                                            {{ $resep->kunjungan->pasien->nama }}</option>
                                                        @foreach ($Rekmed as $rm)
                                                            @if ($rm->id !== $resep->kunjungan_id)
                                                                <option value="{{ $rm->pasien_id }}">{{ $rm->pasien->nama }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('kunjungan_id')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
        
                                            <div class="my-2">
                                                <label for="deskripsi" class="h4 f-bolder">Deskripsi</label>
                                                <div class="my-1">
                                                    <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="deskripsi" name="deskripsi" value="{{ $resep->deskripsi }}">
                                                </div>
                                                @error('deskripsi')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
        
                                            <button type="button" class="px-2 py-1 btn-close red-hover" onclick="closeEditModal({{ $resep->id }})">Batal</button>
                                            <button type="submit" class="px-2 py-1 btn-add main-color-hover">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
@endsection
