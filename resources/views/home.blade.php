<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Klinik
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/css/home_dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .history-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .history-section h2 {
            font-size: 24px;
            margin: 0;
        }

        .history-section p {
            margin: 10px 0 20px;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .history-table th,
        .history-table td {
            padding: 10px;
            text-align: left;
        }

        .history-table th {
            background-color: #457b9d;
            color: white;
        }

        .history-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .history-table tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .info-kunjungan {
            padding: 96px 30px 0 30px;
        }

        .custom-dropdown .select2-results {
            max-height: 500px;
            overflow-y: auto;
        }

        .select2-container .select2-selection--single {
            height: 80px;
            display: flex;
            align-items: center;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 80px;
        }
    </style>

</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire('Success', '{{ session('success') }}', 'success');
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire('Error', '{{ session('error') }}', 'error')
        </script>
    @endif
    <nav class="navbar">
        <h1>
            AllCare
        </h1>
        <ul>
            <li><a href="#page-doctor">
                    Dokter
                </a></li>
            <li><a href="#form-section">
                    Pasien
                </a></li>
            <li><a href="#form-section-kunjungan">
                    Buat Kunjungan
                </a></li>
            <li><a href="#patient-info">
                    Riwayat kunjungan
                </a></li>

        </ul>
        <ul>

            <li class="nav-item" style="margin-left: 20px; margin-top: 15px">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
        <div class="gap"></div>
    </nav>
    <section id="hero" class="hero">
        <div class="hero-content">
            <div>
                <h2>
                    Selamat Datang di <br>
                    <span>
                        KLINIK
                    </span>
                </h2>
                <p>
                    Jangan ragu untuk membuat janji temu dengan dokter <br> melalui website ini.
                </p>

            </div>
            <div class="button">
                <a href="#" id="scrollToForm">Janji Temu</a>
            </div>
        </div>
        <div class="img">
            <img alt="Dokter memegang clipboard" src="{{ asset('Medicio/assets/img/doctorphoto.png') }}" />
        </div>
    </section>
    <section id="page-doctor" class="page-doctor">
        <div id="section-title" class="section-title">
            <h3>
                Tim Dokter Spesialis Kami
            </h3>
            <p>
                Kami menghadirkan layanan kesehatan terbaik dengan <br> dukungan dokter berpengalaman di bidangnya.
            </p>
        </div>
        <div id="doctors" class="doctors">
            <div class="doctor-group">
                @foreach ($dokter as $dok)
                    <div class="doctor-card">
                        <img src="{{ asset('storage/dokters/' . $dok->image) }}" height="100px" width="80px"
                            alt="gambar">

                        <h4>
                            {{ $dok->nama }}
                        </h4>
                        <p>
                            {{ $dok->spesialis }}
                        </p>
                        <p>
                            {{ $dok->no_hp }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="form-section" class="form-section">
        <div class="form-left">
            <h3>
                Lengkapi Data <br> Diri Anda
            </h3>
            <p>
                Masukkan informasi Anda untuk <br> membuat janji atau mengakses layanan <br> kami.
            </p>
        </div>
        <div class="form-right" id="form-pasien">
            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf
                <input placeholder="Nama Lengkap" type="text" name="nama" value="{{ old('nama') }}" />
                @error('nama')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <input placeholder="Alamat" type="text" name="alamat" value="{{ old('alamat') }}" />
                @error('alamat')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <input placeholder="Nomor Handphone" type="text" name="no_hp" value="{{ old('no_hp') }}" />
                @error('no_hp')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <input placeholder="Tanggal Lahir" type="date" name="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}" />
                @error('tanggal_lahir')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <button type="submit">
                    Kirim
                </button>
            </form>
        </div>
    </section>
    <section id="patien-info" class="patient-info">
        <h3>
            Informasi Pasien
        </h3>
        <p>
            Data yang Anda isi akan digunakan untuk <br> kebutuhan pelayanan kesehatan.
        </p>
        <div class="container">
            @foreach ($pasien as $pas)
                <div class="patient-card">
                    <b>Data Pasien Anda: {{ $loop->iteration }}</b>
                    <p>
                        <i class="fas fa-user"></i>
                        <span class="label">Nama :</span>
                        <span class="value">{{ $pas->nama }}</span>
                    </p>
                    <p>
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="label">Alamat :</span>
                        <span class="value">{{ $pas->alamat }}</span>
                    </p>
                    <p>
                        <i class="fas fa-phone"></i>
                        <span class="label">No. HP :</span>
                        <span class="value">{{ $pas->no_hp }}</span>
                    </p>
                    <p>
                        <i class="fas fa-calendar-alt"></i>
                        <span class="label">Tgl Lahir :</span>
                        <span class="value">{{ $pas->tanggal_lahir }}</span>
                    </p>
                </div>
            @endforeach
        </div>
    </section>
    <section id="form-section-kunjungan" class="form-section">
        <div class="form-right" id="form-pasien">
            <form action="{{ route('kunjungan.store') }}" method="POST">
                @csrf
                <select name="pasien_id" class="pasien-select-option" style="border-radius: 50px;">
                    <option disabled selected style="border-radius: 50px;">Cari pasien</option>
                    @foreach ($pasien as $pas)
                        <option value="{{ $pas->id }}">{{ $pas->nama }}</option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <input placeholder="keluhan" type="text" name="keluhan" value="{{ old('keluhan') }}" />
                @error('keluhan')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <input placeholder="Tanggal Kunjungan" name="tanggal_kunjungan"
                    value="{{ old('tanggal_kunjungan') }}" type="date">
                @error('tanggal_kunjungan')
                    <p style="color: red">{{ $message }}</p>
                @enderror
                <button type="submit">
                    Kirim
                </button>
            </form>
        </div>
        <div class="form-left">
            <h3>
                Formulir <br> Kunjungan Pasien
            </h3>
            <script>
                document.getElementById('scrollToForm').addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent the default anchor behavior
                    document.getElementById('form-section-kunjungan').scrollIntoView({
                        behavior: 'smooth' // Smooth scroll
                    });
                });
            </script>
            <p>
                Isi detail kunjungan untuk membuat janji <br> temu dengan dokter
            </p>
        </div>
    </section>
    {{-- <section id="info-kunjungan" class="info-kunjungan">
        <div class="history-section">
            <h2>Riwayat Kunjungan Anda</h2>
            <p>Berikut adalah daftar kunjungan yang telah Anda buat.</p>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Nama Dokter</th>
                        <th>Keluhan</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($kunjungan as $kun)
                <tr>
                    <td>{{$kun->pasien->nama}}</td>
                    <td>{{$kun->dokter->nama ?? 'tunggu beberapa saat lagi'}}</td>
                    <td>{{$kun->keluhan}}</td>
                    <td>{{$kun->tanggal_kunjungan}}</td>
                    <td class="action-icons">
                        <button class="edit" type="button" style="border: none; outline: none; background: transparent;" data-bs-toggle="modal"
                        data-bs-target="#editModal{{ $kun->id }}">
                        <i class="fas fa-edit edit"></i>
                        </button>
                        <form id="delete-form-{{ $kun->id }}" action="{{ route('kunjungan.destroy', $kun->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="button" style="background: transparent; outline: none; border: none" onclick="confirmDelete({{ $kun->id }})">
                                <i class="fas fa-trash delete"></i>
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
                                        // Submit form hapus
                                        document.getElementById('delete-form-' + id).submit();
                                    }
                                });
                            }
                        </script>
                    </td>
                </tr>

                <div class="modal fade" id="editModal{{ $kun->id }}" tabindex="-1"
                    aria-labelledby="editModalLabel{{ $kun->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Edit Kunjungan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('kunjungan.update', $kun->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="pasien" class="col-sm-2 col-form-label">Nama Pasien</label>
                                        <div class="col-sm-10">
                                            <select name="pasien_id" class="form-control">
                                                <option value="{{$kun->pasien_id}}">{{$kun->pasien->nama}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="keluhan" class="col-sm-2 col-form-label">Keluhan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="jumlah"
                                                name="keluhan" value="{{ $kun->keluhan }}">
                                        </div>
                                        @error('keluhan')
                                            <script>
                                                Swal.fire('Error', '{{ $message }}', 'error');
                                            </script>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="Tanggal_kunjungan" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="tanggal_kunjungan"
                                                name="tanggal_kunjungan" value="{{ $kun->tanggal_kunjungan }}">
                                        </div>
                                        @error('tanggal_kunjungan')
                                            <script>
                                                Swal.fire('Error', '{{ $message }}', 'error');
                                            </script>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </section> --}}
    <section id="patient-info" class="patient-info">

        <h3>
            Riwayat Kunjungan Anda
        </h3>

        <p>
            Berikut adalah daftar kunjungan yang <br> telah Anda buat.
        </p>
        <div class="container-card-kunjungan" style="flex-direction: column">
            <div class="details-button">
                <i class="fa-regular fa-eye"></i>
                <a href="{{ route('detail') }}">lihat semua</a>
            </div>
            <div class="card-kunjungan">
                @foreach ($kunjunganhistory->take(3) as $kunj)
                    <div class="patient-card">
                        <h2 style="font-weight: bold;">Data Anda: </h2>
                        <p>
                            <i class="fas fa-user"></i>
                            <span class="label">Nama :</span>
                            <span style="font-weight: bolder; color:#000;"
                                class="value">{{ $kunj->pasien->nama }}</span>
                        </p>
                        {{-- <p>
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="label">Dokter :</span>
                        <span class="value">{{ $kunj->dokter-nama }}</span>
                    </p> --}}
                        <p>
                            <i class="fas fa-phone"></i>
                            <span class="label">Keluhan :</span>
                            <span class="value">{{ $kunj->keluhan }}</span>
                        </p>
                        <p>
                            <i class="fas fa-calendar-alt"></i>
                            <span class="label">Tanggal Kunjungan :</span>
                            <span class="value">{{ $kunj->tanggal_kunjungan }}</span>
                            <!-- Tombol Detail -->
                            @if ($kunj->rekamMedis->isNotEmpty())
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $kunj->rekamMedis->id }}">
                                Detail
                            </a>

                            <!-- Modal -->
                        <div class="modal fade" id="detailModal{{ $kunj->rekamMedis->id }}" tabindex="-1"
                            aria-labelledby="detailModalLabel{{ $kunj->rekamMedis->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel{{ $kunj->rekamMedis->id }}">
                                            Detail Rekam Medis
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Pasien:</strong> {{ $kunj->rekamMedis->kunjungan->pasien->nama }}
                                        </p>
                                        <p><strong>Diagnosa:</strong> {{ $kunj->rekamMedis->diagnosa }}</p>
                                        <p><strong>Tindakan:</strong> {{ $kunj->rekamMedis->tindakan }}</p>

                                        <p><strong>Obat:</strong></p>
                                        @if ($kunj->rekamMedis->obats && $kunj->rekamMedis->obats->count() > 0)
                                            @foreach ($kunj->rekamMedis->obats as $obat)
                                                <p>{{ $obat->obat }} - Jumlah: {{ $obat->pivot->jumlah }}</p>
                                            @endforeach
                                        @else
                                            <p>Tidak ada obat yang terkait</p>
                                        @endif
                                        <p><strong>Resep:</strong>
                                            @if ($kunj->rekamMedis->resep)
                                                @foreach ($kunj->rekamMedis->resep as $resep)
                                                    <p>{{ $resep->deskripsi }}</p>
                                                @endforeach
                                            @else
                                                <p>Tidak ada resep</p>
                                            @endif
                                        </p>
                                        <p><strong>Peralatan:</strong>
                                            @if ($kunj->rekamMedis->peralatans && $kunj->rekamMedis->peralatans->count() > 0)
                                                @foreach ($kunj->rekamMedis->peralatans as $peralatan)
                                                    <tr>
                                                        <td>{{ $peralatan->nama_peralatan }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>Tidak ada peralatan yang terkait</td>
                                                </tr>
                                            @endif
                                        </p>
                                        <p><strong>Gambar:</strong></p>
                                        @foreach ($kunj->rekamMedis->images as $image)
                                            <img src="{{ asset('storage/' . $image->image_path) }}" height="150"
                                                width="120" class="mb-2" alt="Gambar">
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="px-2 py-1 btn-close red-hover"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p>Tidak ada rekam medis untuk kunjungan ini.</p>
                @endif
                </p>
            </div>
            @endforeach
        </div>
        </div>
    </section>

</body>
<script>
    document.querySelectorAll('nav a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.pasien-select-option').select2();
    });
</script>


</html>
