@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="ml-3 mr-3">
        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center mx-2">
                <h2 class="h2 f-bolder mr-4">Data Jadwal Praktik</h2>
                {{-- <div class="btn"></div> --}}
                @if (auth()->user()->hasRole('admin'))
                    <button type="button" class="btn-add main-color-hover" id="btnOpenAddModal">
                        Tambah Jadwal Praktik
                    </button>
                @endif
            </div>
        </div>
        <hr class="mr-3 ml-3">
        <div class="content-table m-2 d-flex col">
            <form method="GET" style="align-items: center;" action="{{ route('jadwal_praktek.index') }}"
                class="d-flex w-100 gap-2">
                <div class="d-flex w-100 col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Cari Nama Dokter</label>
                    <input type="text" class="search-container w-100 h4" name="search" placeholder="Cari Nama Dokter"
                        value="{{ request('search') }}">
                </div>

                <div class="d-flex w-100 col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Cari Hari</label>
                    <select class="search-container w-100 h4" name="search_hari" onchange="this.form.submit()">
                        <option value="">Pilih Hari</option>
                        <option value="Senin" {{ request('search_hari') == 'Monday' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ request('search_hari') == 'Tuesday' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ request('search_hari') == 'Wednesday' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ request('search_hari') == 'Thursday' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ request('search_hari') == 'Friday' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ request('search_hari') == 'Saturday' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ request('search_hari') == 'Sunday' ? 'selected' : '' }}>Minggu</option>
                    </select>
                </div>

                <div class="d-flex col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Jam Mulai</label>
                    <input type="time" class="search-container w-100 h4" name="start_time"
                        value="{{ request('start_time') }}" onchange="this.form.submit()">
                </div>

                <div class="d-flex col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for="">Jam Selesai</label>
                    <input type="time" class="search-container w-100 h4" name="end_time"
                        value="{{ request('end_time') }}" onchange="this.form.submit()">
                </div>

                <button type="submit" class="invisible-btn">Cari</button>

                <a href="{{ route('jadwal_praktek.index') }}" style="height: 50%; align-items: center;"
                    class="btn-add">Clear</a>

                <style>
                    .invisible-btn {
                        opacity: 0;
                        position: absolute;
                        pointer-events: none;
                    }
                </style>
            </form>

            <style>
                .invisible-btn {
                    opacity: 0;
                    position: absolute;
                    pointer-events: none;
                }
            </style>

            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Dokter</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                @if (auth()->user()->hasRole('admin'))
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalPrakteks as $jadwal)
                                <tr>
                                    <td>{{ $jadwal->dokter->nama }}</td>
                                    @php
                                        $days = [
                                            'Monday' => 'Senin',
                                            'Tuesday' => 'Selasa',
                                            'Wednesday' => 'Rabu',
                                            'Thursday' => 'Kamis',
                                            'Friday' => 'Jumat',
                                            'Saturday' => 'Sabtu',
                                            'Sunday' => 'Minggu',
                                        ];
                                        $hariIndo = $days[$jadwal->hari] ?? $jadwal->hari; // Default to English if not found
                                    @endphp

                                    <td>{{ $hariIndo }}</td>

                                    <td>{{ $jadwal->jam_mulai }}</td>
                                    <td>{{ $jadwal->jam_selesai }}</td>

                                    @if (auth()->user()->hasRole('admin'))
                                        <td class="action-icons">
                                            <button type="button"
                                                style="border: none; outline: none; background: transparent;"
                                                onclick="btnOpenEditModal({{ $jadwal->id }})">
                                                <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                            </button>
                                            <form id="delete-form-{{ $jadwal->id }}"
                                                action="{{ route('jadwal_praktek.destroy', $jadwal->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="submit"
                                                style="background: transparent; outline: none; border: none"
                                                onclick="confirmDelete({{ $jadwal->id }})">
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
            </div>
        </div>

        @foreach ($jadwalPrakteks as $jadwal)
            <div class="modal animate__fadeIn" id="myModalEdit{{ $jadwal->id }}">
                <div class="modal-content animate__animated animate__zoomIn">
                    <h2 class="h2 f-bolder">Edit Jadwal Praktek</h2>
                    <form action="{{ route('jadwal_praktek.update', $jadwal->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="my-2">
                            <label for="dokter" class="h4 f-bolder">Dokter</label>
                            <div class="my-1">
                                <select class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="dokter"
                                    name="dokter_id">
                                    @foreach ($dokters as $dokter)
                                        <option value="{{ $dokter->id }}"
                                            {{ $dokter->id == $jadwal->dokter_id ? 'selected' : '' }}>
                                            {{ $dokter->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="hari" class="h4 f-bolder">Hari</label>
                            <div class="my-1">
                                <select id="hari" name="hari"
                                    class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                    <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa
                                    </option>
                                    <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Sabtu" {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                </select>
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="jam_mulai" class="h4 f-bolder">Jam Mulai</label>
                            <div class="my-1">
                                <input type="time" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="jam_mulai" name="jam_mulai" value="{{ $jadwal->jam_mulai }}">
                            </div>
                        </div>
                        <div class="my-2">
                            <label for="jam_selesai" class="h4 f-bolder">Jam Selesai</label>
                            <div class="my-1">
                                <input type="time" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                    id="jam_selesai" name="jam_selesai" value="{{ $jadwal->jam_selesai }}">
                            </div>
                        </div>

                        <button type="button" class="btn-close red-hover" onclick="closeEditModal()">Batal</button>
                        <button type="submit" class="btn-add main-color-hover">Simpan</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="modal animate__animated" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                <h2 class="h2 f-bolder">Tambah Jadwal Praktek</h2>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                <form action="{{ route('jadwal_praktek.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="dokter_id" class="h4 f-bolder">Dokter</label>
                        <div class="my-1">
                            <select name="dokter_id" id="dokter_id"
                                class="form h4 f-normal px-2 w-100 h-3 border-radius-1">
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="hari" class="h4 f-bolder">Hari</label>
                        <div class="my-1">
                            <select name="hari" id="hari" class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                required>
                                <option value="">Pilih Hari</option>
                                <option value="Monday">Senin</option>
                                <option value="Tuesday">Selasa</option>
                                <option value="Wednesday">Rabu</option>
                                <option value="Thursday">Kamis</option>
                                <option value="Friday">Jumat</option>
                                <option value="Saturday">Sabtu</option>
                            </select>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="jam_mulai" class="h4 f-bolder">Jam Mulai</label>
                        <div class="my-1">
                            <input type="time" id="jam_mulai" name="jam_mulai"
                                class="form h4 f-normal px-2 w-100 h-3 border-radius-1" required>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="jam_selesai" class="h4 f-bolder">Jam Selesai</label>
                        <div class="my-1">
                            <input type="time" id="jam_selesai" name="jam_selesai"
                                class="form h4 f-normal px-2 w-100 h-3 border-radius-1" required>
                        </div>
                    </div>

                    <div class="my-2">
                        <button type="button" id="btnCloseAddModal" class="btn-close red-hover">Batal</button>
                        <button type="submit" class="btn-add main-color-hover">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function btnOpenEditModal(id) {
                fetch(`/jadwal_praktek/${id}/edit`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('dokter').value = data.dokter_id;
                        document.getElementById('hari').value = data.hari;
                        document.getElementById('jam_mulai').value = data.jam_mulai;
                        document.getElementById('jam_selesai').value = data.jam_selesai;
                        document.getElementById('myModalEditJadwal').style.display = 'block'; // Show modal
                    });
            }

            // Close edit modal for Jadwal
            function closeEditModalJadwal() {
                document.getElementById('myModalEditJadwal').style.display = 'none'; // Hide modal
            }

            // Delete Confirmation for Jadwal
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
