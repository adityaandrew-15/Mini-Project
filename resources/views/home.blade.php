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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- <link rel="stylesheet" href="/css/home_dashboard.css"> --}}
    <link href="Medicio/assets/css/main.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    {{-- <link href="Medicio/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="Medicio/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">


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
            background-color: var(--main-color);
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

        .btn-nota-check {
            background: var(--accent-color);
            border: 0;
            padding: 10px 35px;
            color: #fff;
            transition: 0.4s;
            border-radius: 4px;
        }
    </style>

</head>

<body>
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if (session('success'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 7000
                    });
                @endif
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if ($errors->any())
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: `
                        <ul style="text-align: left;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    showConfirmButton: false,
                    timer: 10000
                });
            @endif
        });
    </script>


    {{-- <nav class="navbar">
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
    </nav> --}}
    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="d-none d-md-flex align-items-center ms-auto">
                    <i class="bi bi-clock me-1 "></i> senin - sabtu, 8AM to 10PM
                </div>
                <div class="d-flex align-items-center">
                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-center">


            <div class="container position-relative d-flex align-items-center justify-content-end">
                <a href="/dashboard" class="logo d-flex align-items-center me-auto">
                    <h1>AllCare</h1>
                    <!-- Uncomment the line below if you also wish to use a text logo -->
                    <!-- <h1 class="sitename">AllCore</h1>  -->
                </a>

                <nav id="navmenu" class="navmenu">
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
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                {{-- <a class="cta-btn"
                    href="{{ Auth::check() ? route(Auth::user()->hasRole('admin') ? 'admin-home' : (Auth::user()->hasRole('dokter') ? 'home-dokter' : 'home')) : route('login') }}">
                    {{ Auth::check() ? 'Home' : 'JOIN US' }}
                </a> --}}

                <a class="cta-btn" href="#" onclick="confirmLogout(event)">
                    <i class="fas fa-sign-out-alt"></i> <!-- Ikon Logout -->
                    <span>Logout</span> <!-- Teks Logout -->
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    function confirmLogout(event) {
                        event.preventDefault(); // Mencegah logout langsung

                        Swal.fire({
                            title: "Yakin ingin logout?",
                            text: "Anda akan keluar dari sesi ini.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ya, Logout!",
                            cancelButtonText: "Batal"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById("logout-form").submit(); // Kirim form logout jika dikonfirmasi
                            }
                        });
                    }
                </script>


            </div>

        </div>

    </header>
    <section id="hero" class="hero section">

        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            <div class="carousel-item active">
                <img src="Medicio/assets/img/hero-carousel/hero-carousel-1.jpg" alt="">
                <div class="container">

                    <h2>Selamat Datang di AllCare</h2>
                    <p>Jangan ragu untuk membuat janji temu dengan dokter melalui website ini.</p>
                    <a href="#" id="scrollToForm" class="btn-get-started">lanjut -></a>
                </div>
            </div><!-- End Carousel Item -->

            {{-- <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a> --}}

            <ol class="carousel-indicators"></ol>

        </div>

    </section>
    {{-- <section id="hero" class="hero">
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
    </section> --}}
    <section id="page-doctor" class="doctors section">
        <div id="section-title" class="section-title">
            <h2>
                Tim Dokter Spesialis Kami
            </h2>
            <p>
                Kami menghadirkan layanan kesehatan terbaik dengan <br> dukungan dokter berpengalaman di bidangnya.
            </p>
        </div>
        <div id="doctors" class="container">
            <div class="row">
                @foreach ($dokter as $dok)
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate">
                        <div class="team-member">
                            <div class="member-img">`
                                <img src="{{ asset('storage/' . $dok->image) }}" class="img-fluid"" alt="gambar">
                            </div>
                            <div class="member-info">
                                <h4>
                                    {{ $dok->nama }}
                                </h4>
                                <span>
                                    {{ $dok->spesialis }}
                                </span>
                                <span>
                                    {{ $dok->no_hp }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="form-section" class="appointment section light-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 content aos-init aos-animate" style="position: relative; top: 80px;">
                    <div class="container section-title aos-init aos-animate">
                        <h2>
                            Lengkapi Data <br> Diri Anda
                        </h2>
                        <p>
                            Masukkan informasi Anda untuk <br> membuat janji atau mengakses layanan <br> kami.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 content aos-init aos-animate">
                    <div class="container aos-init aos-animate text-center" id="form-pasien">
                        <form action="{{ route('pasien.store') }}" method="POST" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="form-group mt-3">
                                    <div class="form-group">
                                        <label for="namaLengkap" class="form-label text-start">Nama Lengkap</label>
                                        <input class="form-control" id="namaLengkap" placeholder="Nama Lengkap"
                                            type="text" name="nama" value="{{ old('nama') }}" />
                                        @error('nama')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class=" form-group">
                                        <input class="form-control" placeholder="Alamat" type="text"
                                            name="alamat" value="{{ old('alamat') }}" />
                                        @error('alamat')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class=" form-group">
                                        <input class="form-control" placeholder="Nomor Handphone" type="number"
                                            name="no_hp" value="{{ old('no_hp') }}" />
                                        @error('no_hp')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class=" form-group">
                                        <input class="form-control" placeholder="Tanggal Lahir" type="date"
                                            name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" />
                                        @error('tanggal_lahir')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="text-center">
                                    <button type="submit">
                                        Kirim
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="patien-info" class="featured-services section">
        <div class="container section-title aos-init aos-animate">
            <h2>
                Informasi Pasien
            </h2>
            <p>
                Data yang Anda isi akan digunakan untuk <br> kebutuhan pelayanan kesehatan.
            </p>
        </div>
        <div class="container">
            @if ($pasien->isEmpty())
                <span>Tidak Ada Data</span>
            @else
                <div class="row gy-4">
                    @foreach ($pasien as $pas)
                        <div class="col-md-6 aos-init aos-animate">
                            <div class="service-item position-relative">
                                {{-- <h2>Data Pasien Anda: {{ $loop->iteration }}</h2> --}}
                                <h2>Data Pasien : <span class="value">{{ $pas->nama }}</span></h2>
                                {{-- <p>
                                <i class="fas fa-user"></i>
                                <span class="label">Nama :</span>
                                <span class="value">{{ $pas->nama }}</span>
                            </p> --}}
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
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    <section id="form-section-kunjungan" class="appointment section light-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 content aos-init aos-animate">
                    <div class="container section-title aos-init aos-animate" id="form-pasien">
                        <form action="{{ route('kunjungan.store') }}" method="POST" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="form-group mt-3">
                                    <div class="form-group mt-3">
                                        <select name="pasien_id" class="form-select">
                                            <option disabled selected>Cari pasien</option>
                                            @foreach ($pasien as $pas)
                                                <option value="{{ $pas->id }}">{{ $pas->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pasien_id')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <div class="form-group">
                                        <input placeholder="keluhan" class="form-control" type="text"
                                            name="keluhan" value="{{ old('keluhan') }}" />
                                    </div>
                                    @error('keluhan')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <div class="form-group">
                                        <input placeholder="Tanggal Kunjungan" class="form-control datepicker"
                                            name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}"
                                            type="date">
                                    </div>
                                    @error('tanggal_kunjungan')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="text-center">
                                    <button type="submit">
                                        Kirim
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 content aos-init aos-animate" style="position: relative; top: 80px;">
                    <div class="container section-title aos-init aos-animate">
                        <h2>
                            Formulir Kunjungan Pasien
                        </h2>
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
                </div>
            </div>
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
    <section id="patient-info" class="featured-services section">
        <div class="container section-title aos-init aos-animate">
            <h2>
                Riwayat Kunjungan Anda
            </h2>
            <p>
                Berikut adalah daftar kunjungan yang <br> telah Anda buat.
            </p>
        </div>
        <div class="container">
            @if ($kunjunganhistory->isEmpty())
                <span>Tidak Ada Data</span>
            @else
                <div class="row gy-4">
                    @foreach ($kunjunganhistory->take(3) as $kunj)
                        <div class="col-md-6">
                            <div class="service-item position-relative">
                                {{-- <h2>Data Anda</h2> --}}
                                <h2>Data Kunjungan : <span class="value">{{ $kunj->pasien->nama }}</span></h2>
                                {{-- <p>
                                    <i class="fas fa-user"></i>
                                    <span class="label">Nama :</span>
                                    <span class="value">{{ $kunj->pasien->nama }}</span>
                                </p> --}}
                                <p>
                                    <i class="fas fa-phone"></i>
                                    <span class="label">Keluhan :</span>
                                    <span class="value">{{ $kunj->keluhan }}</span>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span class="label">Tanggal Kunjungan :</span>
                                    <span class="value">{{ $kunj->tanggal_kunjungan }}</span>
                                </p>
                                @if ($kunj->rekamMedis->isNotEmpty())
                                    <div class="text-start mt-4">
                                        <a href="#" class="btn btn-nota-check"
                                            id="detailBtn{{ $kunj->rekamMedis->first()->id }}">
                                            <p>Detail</p>
                                        </a>
                                    </div>

                                    <script>
                                        document.getElementById('detailBtn{{ $kunj->rekamMedis->first()->id }}').addEventListener('click', function(
                                            event) {
                                            event.preventDefault(); // Mencegah aksi default tombol

                                            let content = `
                                                <div style="display: flex; align-items: flex-start; gap: 20px;">
                                                    <!-- Bagian Kiri (Teks) -->
                                                    <div style="flex: 1; font-size: 16px;">
                                                        <strong>Pasien:</strong> <br> {{ $kunj->rekamMedis->first()->kunjungan->pasien->nama }} <br><br>
                                                        <strong>Diagnosa:</strong> <br> {{ $kunj->rekamMedis->first()->diagnosa }} <br><br>
                                                        <strong>Tindakan:</strong> <br> {{ $kunj->rekamMedis->first()->tindakan }} <br><br>
                                    
                                                        <strong>Obat:</strong> <br>
                                                        @if ($kunj->rekamMedis->first()->obats->isNotEmpty())
                                                            @foreach ($kunj->rekamMedis->first()->obats as $obat)
                                                                {{ $obat->obat }} - Jumlah: {{ $obat->pivot->jumlah }}<br>
                                                            @endforeach
                                                        @else
                                                            Tidak ada obat yang terkait <br>
                                                        @endif
                                                        <br>
                                    
                                                        <strong>Peralatan:</strong> <br>
                                                        @if ($kunj->rekamMedis->first()->peralatans->isNotEmpty())
                                                            @foreach ($kunj->rekamMedis->first()->peralatans as $peralatan)
                                                                {{ $peralatan->nama_peralatan }}<br>
                                                            @endforeach
                                                        @else
                                                            Tidak ada peralatan yang terkait <br>
                                                        @endif
                                                    </div>
                                    
                                                    <!-- Bagian Kanan (Gambar) -->
                                                    <div style="flex: 1; text-align: center;">
                                                         <strong>Gambar:</strong> <br>
                                                        @if ($kunj->rekamMedis->first()->images->isNotEmpty())
                                                            @foreach ($kunj->rekamMedis->first()->images as $image)
                                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                                     style="max-width: 50%; height: auto; border-radius: 10px;" 
                                                                     alt="Gambar">
                                                            @endforeach
                                                        @else
                                                            <p>Tidak ada gambar yang terkait</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            `;

                                            Swal.fire({
                                                title: 'Detail Rekam Medis',
                                                html: content,
                                                showCloseButton: true,
                                                confirmButtonText: 'Close',
                                                showCancelButton: true,
                                                cancelButtonText: '<i class="fa-solid fa-print"></i> Cek Nota',
                                                cancelButtonAriaLabel: 'Cek Nota',
                                                width: '70%',
                                                padding: '20px',
                                                didOpen: () => {
                                                    document.body.style.overflow = 'hidden';
                                                },
                                                didClose: () => {
                                                    document.body.style.overflow = 'auto';
                                                }
                                            }).then((result) => {
                                                if (result.dismiss === Swal.DismissReason.cancel) {
                                                    window.location.href =
                                                        "{{ route('rekam_medis.nota', $kunj->rekamMedis->first()->id) }}";
                                                }
                                            });
                                        });
                                    </script>
                                @else
                                    <p>Tidak ada rekam medis untuk kunjungan ini.</p>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="text-end mt-4">
                <a href="{{ route('detail') }}" class="cta-btn">Lihat semua</a>
            </div>
        </div>
    </section>
    <footer id="contact" class="footer light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">AllCare</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>A108 Adam Street</p>
                        <p>New York, NY 535022</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                        <p><strong>Email:</strong> <span>info@example.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Hic solutasetp</h4>
                    <ul>
                        <li><a href="#">Molestiae accusamus iure</a></li>
                        <li><a href="#">Excepturi dignissimos</a></li>
                        <li><a href="#">Suscipit distinctio</a></li>
                        <li><a href="#">Dilecta</a></li>
                        <li><a href="#">Sit quas consectetur</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Nobis illum</h4>
                    <ul>
                        <li><a href="#">Ipsam</a></li>
                        <li><a href="#">Laudantium dolorum</a></li>
                        <li><a href="#">Dinera</a></li>
                        <li><a href="#">Trodelas</a></li>
                        <li><a href="#">Flexo</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Medicio</strong> <span>All Rights Reserved</span>
            </p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>
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
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>

</html>
