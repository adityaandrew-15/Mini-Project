@extends('layouts.sidebar')
<!-- Link CSS Bootstrap -->
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

<!-- Link JS Bootstrap -->
<style>
    .content-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
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
        height: 300px;
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
    <div class="m-3">
        {{-- @if (auth()->user()->unreadNotifications->count())
    <div class="alert alert-info">
        Anda memiliki {{ auth()->user()->unreadNotifications->count() }} notifikasi baru!
        <a href="{{ route('notifikasi.index') }}">Lihat Notifikasi</a>
    </div>
    @endif --}}
        {{-- 
        @if (session('success'))
            <script>
                Swal.fire('Success', '{{ session('success') }}', 'success');
            </script>
        @endif --}}
        {{-- <div class="header">
            <input type="text" placeholder="Search"><i class="fa-solid fa-magnifying-glass" style="margin-left: -100px"></i>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button><i class="fas fa-sign-out-alt"></i> Keluar</button>
            </form>
        </div> --}}
        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center">
                <h2 class="h2 f-bolder mr-4">Data Kunjungan</h2>
                <div class="btn"></div>
                <button type="button" class="btn-add" id="btnOpenAddModal">
                    Tambah Data Kunjungan
                </button>
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
                        @foreach ($kunjungans as $kunjungan)
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
                                <a href="{{ route('kunjhistoryshow', $kunjungan->id) }}" class="btn-add"">
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
            </div>
            <a style="text-align: right;" href="{{ route('kunjungan.index') }}">Kembali ke kunjungan</a>
        </div>

        <script>
            function showContent(id) {
                // Sembunyikan semua konten
                document.querySelectorAll('.content').forEach((el) => el.classList.remove('active'));

                // Tampilkan yang dipilih
                document.getElementById(id).classList.add('active');

                // Update tab aktif
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

                    // Create input fields for each selected medication
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
                    input.name = 'jumlah_obat[]'; // Ensure this is an array
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

        {{-- iki modal tambah kunjungan --}}
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
                    <button type="submit" class="px-2 py-1 btn-add">Simpan</button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                                <p class="h4 my-1">Tidak ada rekam medis untuk kunjungan ini.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-close" data-bs-dismiss="modal">Tutup</button>
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
                    <button type="button" class="btn-close" onclick="closeEditModal({{ $kunjungan->id }})"></button>

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

                        <button type="button" class="px-2 py-1 btn-close red-hover"
                            onclick="closeEditModal({{ $kunjungan->id }})">Batal</button>
                        <button type="submit" class="px-2 py-1 btn-add">Simpan</button>
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
