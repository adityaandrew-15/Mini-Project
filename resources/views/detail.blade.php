<!DOCTYPE html>
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
    <link rel="stylesheet" href="/css/detail.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="Medicio/assets/css/main.css" rel="stylesheet">
</head>

<body>
    {{-- <nav class="navbar">
        <h1>
            AllCare
        </h1>
        <ul>
            <li><a href="{{ url('/home#page-doctor') }}">
                    Dokter
                </a></li>
            <li><a href="{{ url('/home#form-section') }}">
                    Pasien
                </a></li>
            <li><a href="{{ url('/home#form-section-kunjungan') }}">
                    Buat Kunjungan
                </a></li>
            <li><a href="{{ url('/home#patient-info') }}">
                    Riwayat Kunjungan
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
                        <li><a href="{{ url('/home#page-doctor') }}">
                                Dokter
                            </a></li>
                        <li><a href="{{ url('/home#form-section') }}">
                                Pasien
                            </a></li>
                        <li><a href="{{ url('/home#form-section-kunjungan') }}">
                                Buat Kunjungan
                            </a></li>
                        <li><a href="{{ url('/home#patient-info') }}">
                                Riwayat Kunjungan
                            </a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                <a class="cta-btn" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <!-- Ikon Logout -->
                    <span>Logout</span> <!-- Teks Logout -->
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        </div>

    </header>
    <section id="patien-info" class="patient-info">
        <h3>
            Riwayat Kunjungan Anda
        </h3>
        <div class="container">
            {{-- <div class="patient-card">
                <h2 style="font-weight: bold;">Data Anda: </h2>
                <p>
                    <i class="fas fa-user"></i>
                    <span class="label">Nama :</span>
                    <span style="font-weight: bolder; color:#000;" class="value">Nama</span>
                </p>
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="label">Dokter :</span>
                    <span class="value">Dokter</span>
                </p>
                <p>
                    <i class="fas fa-phone"></i>
                    <span class="label">Keluhan :</span>
                    <span class="value">Keluhan</span>
                </p>
                <p>
                    <i class="fas fa-calendar-alt"></i>
                    <span class="label">Tanggal Kunjungan :</span>
                    <span class="value">Tanggal Kunjungan</span>
                </p>
                <div class="button-details">
                    <div class="details-button">
                        <i class="fa-regular fa-eye"></i>
                        <a href="#">Detail</a>
                    </div>
                </div>
            </div> --}}
            @foreach ($kunjunganhistory as $kunj)
                <div class="patient-card">
                    <h5 style="font-weight: bold;">Data pasien: </h5>
                    <p>
                        <i class="fas fa-user"></i>
                        <span class="label">Nama :</span>
                        <span style="font-weight: bolder; color:#000;" class="value">{{ $kunj->pasien->nama }}</span>
                    </p>
                    <p>
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="label">Dokter :</span>
                        <span class="value">{{ $kun->dokter->nama ?? 'tunggu beberapa saat lagi' }}</span>
                    </p>
                    <p>
                        <i class="fas fa-phone"></i>
                        <span class="label">Keluhan :</span>
                        <span class="value">{{ $kunj->keluhan }}</span>
                    </p>
                    <p>
                        <i class="fas fa-calendar-alt"></i>
                        <span class="label">Tanggal Kunjungan :</span>
                        <span class="value">{{ $kunj->tanggal_kunjungan }}</span>
                    </p>
                </div>
            @endforeach
        </div>
    </section>
    <footer>
        <div class="footer-container">
            <!-- Klinik -->
            <div class="footer-column">
                <h3>Klinik</h3>
                <p>
                    Klinik Sehat Bersama<br>
                    Jalan Kebahagiaan No. 123<br>
                    Kota Sejahtera, 45678<br>
                </p>
            </div>

            <!-- Hubungi Kami -->
            <div class="footer-column">
                <h3>Hubungi Kami</h3>
                <ul>
                    <li><span><i class="fa-solid fa-phone"></i></span> : 021-123-4567</li>
                    <li><span><i class="fa-regular fa-envelope"></i></span> : info@kliniksehat.com</li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="footer-column">
                <h3>Social Media</h3>
                <div class="social-icons">
                    <a href="#" title="Facebook"><i class="fab fa-youtube"></i> <span>youtube</span></a>
                    <a href="#" title="Instagram"><i class="fab fa-facebook"></i> <span>facebook</span></a>
                    <a href="#" title="Twitter"><i class="fab fa-instagram"></i> <span>instagram</span></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
