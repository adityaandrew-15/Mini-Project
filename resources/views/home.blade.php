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

        .form-group {
            position: relative;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #aaa;
            border-radius: 5px;
            outline: none;
        }

        label {
            position: absolute;
            left: 12px;
            top: 45%;
            transform: translateY(-50%);
            /* background: white; */
            padding: 0 5px;
            font-size: 16px;
            color: #999;
            transition: 0.3s ease-in-out;
            pointer-events: none;
            top: -14px;

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

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="d-none d-md-flex align-items-center ms-auto">
                    <i class="bi bi-clock me-1 "></i> senin - sabtu, 8AM to 10PM
                </div>
                <div class="d-flex align-items-center">
                </div>
            </div>
        </div>

        <div class="branding d-flex align-items-center">
            <div class="container position-relative d-flex align-items-center justify-content-end">
                <a href="/dashboard" class="logo d-flex align-items-center me-auto">
                    <h1>AllCare</h1>
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
            </div>
            <ol class="carousel-indicators"></ol>
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
                                <div class="form-group mt-4">
                                    <div class="form-group">
                                        <input class="form-control" id="namaLengkap" placeholder=" " type="text"
                                            name="nama" value="{{ old('nama') }}" />
                                        <label for="namaLengkap">Nama Lengkap</label>
                                        @error('nama')
                                            <p style="color: red; position: absolute; right: 0;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <div class=" form-group">
                                        <input class="form-control" placeholder=" " type="text" name="alamat"
                                            id="alamat" value="{{ old('alamat') }}" />
                                        <label for="alamat">Alamat</label>
                                        @error('alamat')
                                            <p style="color: red; position: absolute; right: 0;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <div class=" form-group">
                                        <input class="form-control" placeholder=" " type="number" name="no_hp"
                                            id="no_hp" value="{{ old('no_hp') }}" />
                                        <label for="no_hp">Nomor Handphone</label>
                                        @error('no_hp')
                                            <p style="color: red; position: absolute; right: 0;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <div class=" form-group">
                                        <input class="form-control" placeholder=" " type="date"
                                            name="tanggal_lahir" id="tgl_lahir"
                                            value="{{ old('tanggal_lahir') }}" />
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        @error('tanggal_lahir')
                                            <p style="color: red; position: absolute; right: 0;">{{ $message }}</p>
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
            <div class="text-end mt-4 mb-4">
                <a href="{{ route('listpasien') }}" class="cta-btn">Lihat semua</a>
            </div>
            @if ($pasien->isEmpty())
                <span>Tidak Ada Data</span>
            @else
                <div class="row">
                    @foreach ($pasien->take(3) as $pas)
                        <div class="col-md-4 aos-init aos-animate">
                            <div class="service-item position-relative">
                                {{-- <h2>Data Pasien Anda: {{ $loop->iteration }}</h2> --}}
                                <h4>Data Pasien : <span class="value">{{ $pas->nama }}</span></h4>
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
                                <form id="delete-form-{{ $pas->id }}"
                                    action="{{ route('pasien.destroy', $pas->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="submit" class="header cta-btn mt-4"
                                    onclick="confirmDelete({{ $pas->id }})">Hapus</button>
                                <script>
                                    function confirmDelete(id) {
                                        Swal.fire({
                                            title: 'Apakah Anda yakin?',
                                            text: "Data pasien ini akan dihapus secara permanen!",
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

                                <div class="form-group mt-4">
                                    <div class="form-group">
                                        <input placeholder="Tanggal Kunjungan" class="form-control datepicker"
                                            name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}"
                                            type="date">
                                        <label for="tgl_kunjungan">Tanggal Kunjungan</label>
                                    </div>
                                    @error('tanggal_kunjungan')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group mt-4">
                                    <div class="form-group">
                                        <select name="pasien_id" class="form-select">
                                            <option disabled selected>Cari pasien</option>
                                            @foreach ($pasien as $pas)
                                                <option value="{{ $pas->id }}">{{ $pas->nama }}</option>
                                            @endforeach
                                        </select>
                                        <label for="nama_pasien">Nama Pasien</label>
                                    </div>
                                    @error('pasien_id')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group mt-4">
                                    <div class="form-group">
                                        <textarea name="keluhan" id="" class="forn-control" rows="4"></textarea>
                                        {{-- <input placeholder=" " class="form-control" type="text" name="keluhan"
                                            value="{{ old('keluhan') }}" /> --}}
                                        <label for="keluhan">Keluhan</label>
                                    </div>
                                    @error('keluhan')
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
            <div class="text-end mt-4 mb-4">
                <a href="{{ route('detail') }}" class="cta-btn">Lihat semua</a>
            </div>
            @if ($kunjunganhistory->isEmpty())
                <div class="container mb-5 mt-5">
                    <h2 class="text-center">Tidak ada data</h2>
                </div>
            @else
                <div class="row">
                    @foreach ($kunjunganhistory->take(3) as $kunj)
                        <div class="col-md-4">
                            <div class="service-item position-relative">
                                {{-- <h2>Data Anda</h2> --}}
                                <h4 class="mb-3"><strong>Data Kunjungan : </strong><span
                                        class="value">{{ $kunj->pasien->nama }}</span></h4>
                                {{-- <p>
                                    <i class="fas fa-user"></i>
                                    <span class="label">Nama :</span>
                                    <span class="value">{{ $kunj->pasien->nama }}</span>
                                </p> --}}
                                <p class="mb-2">
                                    <i class="fas fa-phone"></i>
                                    <span class="label">Keluhan :</span>
                                    <span
                                        class="value">{{ \Illuminate\Support\Str::limit($kunj->keluhan, 50, '...') }}</span>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span class="label">Tanggal Kunjungan :</span>
                                    <span class="value">{{ $kunj->tanggal_kunjungan }}</span>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-user"></i>
                                    <span class="label">Status :</span>
                                    <span class="value">
                                        @if ($kunj->status == 'REJECT')
                                            <span class="value">Kunjungan di tolak oleh dokter</span>
                                        @else
                                            <span class="value">
                                                @if ($kunj->status == 'DONE')
                                                    Selesai
                                                @elseif($kunj->status == 'PENDING')
                                                    Menunggu Pembayaran
                                                @elseif($kunj->status == 'UNDONE')
                                                    Belum Direspon Dokter
                                                @else
                                                    Status Tidak Dikenal
                                                @endif
                                            </span>
                                        @endif
                                    </span>
                                </p>
                                {{-- @if ($kunj->rekamMedis->isNotEmpty()) --}}
                                <div class="text-start mt-4">
                                    <a href="{{ route('pendingdetails', $kunj->id) }}" class="btn-custom"
                                        {{-- id="detailBtn{{ $kunj->rekamMedis->first()->id }}" --}}>
                                        Detail
                                    </a>
                                </div>

                                {{-- @else --}}
                                {{-- <p>Tidak ada rekam medis untuk kunjungan ini.</p> --}}
                                {{-- @endif --}}

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
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
                            <div class="member-img">
                                <img src="{{ Storage::exists('public/' . $dok->image) ? asset('storage/' . $dok->image) : asset('asset/img/dokter.png') }}"
                                    class="img-fluid" alt="">
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
