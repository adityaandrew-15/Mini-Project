<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>AllCare</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="medicio/assets/img/favicon.png" rel="icon">
    <link href="medicio/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="medicio/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="medicio/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="medicio/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="medicio/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="medicio/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="medicio/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="medicio/assets/css/main.css" rel="stylesheet">
</head>

<style>
    .homepage-search-block1 {
        height: 100%;
    }

    .bg-user {
        background: url(../images/Background3.svg);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        height: 25vh;
    }

    .bg-landing {
        background-color: #3fbbc0 !important;
    }

    .icon-lg {
        font-size: 4rem;
        /* Ukuran dapat disesuaikan */
        color: white;
    }

    h6 {
        margin: 0;
        font-size: 1.99rem;
        font-weight: bold;
        color: #ffffff;
    }
</style>

<body class="index-page">

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
                        <li><a href="#hero" class="active">Home</a></li>
                        <li><a href="#about">tentang</a></li>
                        <li><a href="#services">layanan</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                <a class="cta-btn"
                    href="{{ Auth::check() ? route(Auth::user()->hasRole('admin') ? 'admin-home' : (Auth::user()->hasRole('dokter') ? 'home-dokter' : 'home')) : route('login') }}">
                    {{ Auth::check() ? 'Home' : 'JOIN US' }}
                </a>


            </div>

        </div>

    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel"
                data-bs-interval="5000">

                <div class="carousel-item active">
                    <img src="medicio/assets/img/hero-carousel/hero-carousel-1.jpg" alt="">
                    <div class="container">

                        <h2>Selamat Datang di AllCare</h2>

                        <p>Kami hadir untuk memberikan pelayanan kesehatan terbaik bagi Anda dan keluarga. Dengan tenaga
                            medis yang profesional, fasilitas yang modern, serta komitmen terhadap kenyamanan pasien,
                            kami siap menjadi mitra terpercaya dalam menjaga kesehatan Anda.</p>
                        <a href="#about" class="btn-get-started">lanjut -></a>
                    </div>
                </div><!-- End Carousel Item -->

                <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>

                <ol class="carousel-indicators"></ol>

            </div>

        </section>
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang <br></h2>
                <p>Klinik bukan hanya tentang pengobatan, tapi juga tentang memberikan harapan kepada mereka yang
                    membutuhkan.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">
                    <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
                        <img src="medicio/assets/img/allcare2.webp" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
                        <h3>AllCare</h3>
                        <p class="fst-italic">
                            Selamat datang di AllCare, tempat di mana kesehatan Anda adalah prioritas utama kami. Kami
                            berdedikasi untuk memberikan pelayanan medis yang profesional, ramah, dan berkualitas
                            tinggi. Klinik kami menyediakan berbagai layanan kesehatan yang didukung oleh tenaga medis
                            yang berpengalaman dan fasilitas modern, untuk memastikan setiap pasien mendapatkan
                            perawatan terbaik
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-all"></i> <span>Mengedepankan kenyamanan dan keselamatan pasien
                                    dalam setiap tahap perawatan.
                                </span></li>
                            <li><i class="bi bi-check2-all"></i> <span>Memberikan pelayanan medis yang terpercaya dan
                                    berorientasi pada pasien.
                                </span></li>
                            <li><i class="bi bi-check2-all"></i> <span>Meningkatkan kualitas hidup melalui pencegahan
                                    dan pengobatan yang tepat.
                                </span></li>
                        </ul>
                    </div>
                </div>

            </div>

        </section>

        <!-- Stats Section -->
        {{-- <section id="stats" class="stats section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="fas fa-user-md flex-shrink-0"></i>
                            <div>
                                <span data-purecounter-start="0"
                                    data-purecounter-end="{{ DB::table('dokters')->count() }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p style="font-weight: bold">Doctors</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="bi bi-people"></i>
                            <div>
                                <span data-purecounter-start="0"
                                    data-purecounter-end="{{ DB::table('pasiens')->count() }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p style="font-weight: bold">Jumlah Pasien</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item d-flex align-items-center w-100 h-100">
                            <i class="fas fa-pills"></i>
                            <div>
                                <span data-purecounter-start="0"
                                    data-purecounter-end="{{ DB::table('obats')->count() }}"
                                    data-purecounter-duration="1"
                                    class="purecounter">{{ DB::table('obats')->count() }}</span>
                                <p style="font-weight: bold">Obat</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section> --}}

        <!-- Features Section -->

        <section class="py-5 homepage-search-block1 bg-landing bg-user position-relative">
            <div class="container">
                <div class="row justify-content-center d-flex text-center">
                    <div class="col-lg-3 justify-content-center d-flex align-items-center my2">
                        <div class="stats-item d-flex align-items-center ">
                            <i class="fas fa-user-md icon-lg flex-shrink-0"></i>
                        </div>
                        <div class="text-content ml-3 text-white">
                            <h6>
                                <span data-purecounter-start="0"
                                    data-purecounter-end="{{ DB::table('dokters')->count() }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                            </h6>
                            <span class="span-1">Dokter</span>
                        </div>
                    </div>

                    <div class="col-lg-3 justify-content-center d-flex align-items-center my2">
                        <div class="stats-item d-flex align-items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75"
                                viewBox="0 0 16 16">
                                <path fill="#ffff"
                                    d="M7 14s-1 0-1-1s1-4 5-4s5 3 5 4s-1 1-1 1zm4-6a3 3 0 1 0 0-6a3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5a2.5 2.5 0 0 0 0 5" />
                            </svg>
                        </div>
                        <div class="text-content ml-3 text-white">
                            <h6>
                                <span data-purecounter-start="0"
                                    data-purecounter-end="{{ DB::table('pasiens')->count() }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                            </h6>
                            <span class="span-1">Jumlah Pasien</span>
                        </div>
                    </div>

                    <div class="col-lg-3 justify-content-center d-flex align-items-center my2">
                        <div class="stats-item d-flex align-items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75"
                                viewBox="0 0 24 24">
                                <path fill="#ffff"
                                    d="M16.2 3.5c-1-1-2.3-1.5-3.5-1.5s-2.6.5-3.5 1.5L3.4 9.1c-2 2-2 5.1 0 7.1s5.1 2 7.1 0l5.7-5.7c1.9-1.9 1.9-5.1 0-7m-1.4 5.6L12 11.9L8.4 8.4L4 12.8c0-.8.2-1.7.9-2.3l5.7-5.7c.5-.5 1.3-.8 2-.8s1.5.3 2.1.8c1.2 1.3 1.2 3.1.1 4.3m4.8-2c0 .8-.2 1.5-.4 2.3c1 1.2 1 3-.1 4.1l-2.8 2.8l-1.5-1.5l-2.8 2.8c-1.3 1.3-3.1 2-4.8 2c.2.3.4.6.7.9c2 2 5.1 2 7.1 0l5.7-5.7c2-2 2-5.1 0-7.1c-.5-.2-.8-.4-1.1-.6" />
                            </svg>
                        </div>
                        <div class="text-content ml-3 text-white">
                            <h6>
                                <span data-purecounter-start="0"
                                    data-purecounter-end="{{ DB::table('obats')->count() }}"
                                    data-purecounter-duration="1" class="purecounter"></span>
                            </h6>
                            <span class="span-1">Jumlah Obat</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services Section -->
        <section id="services" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>Kami memberikan layanan medis umum yang menyeluruh, dari pemeriksaan kesehatan rutin hingga diagnosis
                    penyakit. Dengan tim medis yang profesional dan berpengalaman, kami berkomitmen untuk menjaga
                    kesehatan Anda dengan perhatian penuh dan pelayanan yang ramah</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item  position-relative">
                            <div class="icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <h3>Pemeriksaan Kesehatan Rutin</h3>
                            <p>Pemeriksaan fisik umum untuk memantau kesehatan secara keseluruhan, seperti pengukuran
                                tekanan darah, suhu tubuh, dan pemeriksaan fisik lainnya.
                                Pemeriksaan kesehatan berkala untuk mendeteksi masalah kesehatan sejak dini, seperti
                                diabetes, kolesterol tinggi, atau hipertensi</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <h3>Pengobatan Penyakit Ringan</h3>
                            <p>Pengobatan untuk penyakit umum seperti flu, batuk, demam, pilek, sakit tenggorokan, dan
                                infeksi saluran pernapasan atas.
                                Pengobatan untuk gangguan pencernaan seperti diare, sakit perut, mual, dan muntah</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fas fa-hospital-user"></i>
                            </div>
                            <h3>Penyuluhan Kesehatan</h3>
                            <p>Memberikan edukasi tentang gaya hidup sehat, pola makan yang baik, pentingnya olahraga,
                                manajemen stres, serta pencegahan penyakit.
                                Konseling mengenai kebiasaan sehat, seperti berhenti merokok, mengurangi konsumsi
                                alkohol, dan pola tidur yang baik.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fas fa-dna"></i>
                            </div>
                            <h3>Vaksinasi</h3>
                            <p>Penyediaan vaksin untuk mencegah penyakit menular, seperti vaksinasi untuk anak-anak
                                (misalnya vaksin DPT, polio) dan vaksin untuk orang dewasa (seperti vaksin flu, vaksin
                                hepatitis, vaksin tetanus).
                                Vaksinasi untuk perjalanan internasional (misalnya vaksin hepatitis A, B, atau vaksin
                                demam tifoid)</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fas fa-wheelchair"></i>
                            </div>
                            <h3>Perawatan Luka Ringan</h3>
                            <p>Pengobatan dan perawatan untuk luka ringan, lecet, atau memar.
                                Penanganan cedera ringan seperti keseleo atau patah tulang yang tidak membutuhkan
                                perawatan rumah sakit</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fas fa-notes-medical"></i>
                            </div>
                            <h3>Pemberian Obat-obatan</h3>
                            <p>Pemberian resep obat untuk mengobati kondisi medis yang umum seperti infeksi, nyeri,
                                alergi, atau gangguan lainnya.</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Tabs Section -->
        <section id="tabs" class="tabs section">
        </section>
    </main>

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

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="medicio/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="medicio/assets/vendor/php-email-form/validate.js"></script>
    <script src="medicio/assets/vendor/aos/aos.js"></script>
    <script src="medicio/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="medicio/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="medicio/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="medicio/assets/js/main.js"></script>

</body>

</html>
