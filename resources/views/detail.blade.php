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

    <!-- Vendor CSS Files -->
    {{-- <link href="Medicio/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="Medicio/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
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
    <section id="patien-info" class="featured-services section">
        <div class="container section-title aos-init aos-animate">
            <h2>
                Riwayat Kunjungan Anda
            </h2>
        </div>
        <div class="container">
            @if ($kunjunganhistory->isEmpty())
                <span>Tidak Ada Data</span>
            @else
                <div class="row gy-4">
                    @foreach ($kunjunganhistory as $kunj)
                        <div class="col-md-6 aos-init aos-animate">
                            <div class="service-item position-relative">
                                <h2>Data pasien: </h2>
                                <p>
                                    <i class="fas fa-user"></i>
                                    <span>Nama :</span>
                                    <span class="value">{{ $kunj->pasien->nama }}</span>
                                </p>
                                <p>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Dokter :</span>
                                    <span class="value">{{ $kun->dokter->nama ?? 'tunggu beberapa saat lagi' }}</span>
                                </p>
                                <p>
                                    <i class="fas fa-phone"></i>
                                    <span>Keluhan :</span>
                                    <span class="value">{{ $kunj->keluhan }}</span>
                                </p>
                                <p>
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Tanggal Kunjungan :</span>
                                    <span class="value">{{ $kunj->tanggal_kunjungan }}</span>
                                </p>

                                @if ($kunj->rekamMedis->isNotEmpty())
                                    <h3>Informasi Tambahan</h3>

                                    <p>
                                        <i class="fas fa-pills"></i>
                                        <span>Obat:</span>
                                        @if ($kunj->rekamMedis->first()->obats->isNotEmpty())
                                            <ul>
                                                @php $totalObat = 0; @endphp
                                                @foreach ($kunj->rekamMedis->first()->obats as $obat)
                                                    @php
                                                        $hargaObat = $obat->harga * $obat->pivot->jumlah; // Hitung total harga untuk obat ini
                                                        $totalObat += $hargaObat; // Tambahkan ke total
                                                    @endphp
                                                    <li>{{ $obat->obat }} - Jumlah: {{ $obat->pivot->jumlah }} -
                                                        Harga: Rp{{ number_format($hargaObat, 0, ',', '.') }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="value">Tidak ada obat yang terkait</span>
                                        @endif
                                    </p>

                                    <p>
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Total Harga Obat:</span>
                                        <span class="value">Rp{{ number_format($totalObat, 0, ',', '.') }}</span>
                                    </p>

                                    <p>
                                        <i class="fas fa-tools"></i>
                                        <span>Peralatan:</span>
                                        @if ($kunj->rekamMedis->first()->peralatans->isNotEmpty())
                                            <ul>
                                                @foreach ($kunj->rekamMedis->first()->peralatans as $peralatan)
                                                    <li>{{ $peralatan->nama_peralatan }} - Harga:
                                                        Rp{{ number_format($peralatan->harga, 0, ',', '.') }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="value">Tidak ada peralatan yang terkait</span>
                                        @endif
                                    </p>

                                    <p>
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Total Harga:</span>
                                        <span class="value">
                                            Rp{{ number_format($totalObat + $kunj->rekamMedis->first()->peralatans->sum('harga'), 0, ',', '.') }}
                                        </span>
                                    </p>

                                    <div class="text-start mt-4">
                                        <a href="#" class="btn btn-info btn-sm"
                                            id="detailBtn{{ $kunj->rekamMedis->first()->id }}">
                                            <p>Detail</p>
                                        </a>
                                    </div>
                                @else
                                    <p>Tidak ada rekam medis untuk kunjungan ini.</p>
                                @endif

                                <script>
                                    // Trigger SweetAlert when the button is clicked
                                    document.getElementById('detailBtn{{ $kunj->rekamMedis->first()->id }}').addEventListener('click', function(
                                        event) {
                                        event.preventDefault(); // Prevent default anchor link behavior

                                        // Collect the modal content
                                        let content = `
                <strong>Pasien:</strong> {{ $kunj->rekamMedis->first()->kunjungan->pasien->nama }} <br>
                <strong>Diagnosa:</strong> {{ $kunj->rekamMedis->first()->diagnosa }} <br>
                <strong>Tindakan:</strong> {{ $kunj->rekamMedis->first()->tindakan }} <br>
                <strong>Obat:</strong><br>
                @if ($kunj->rekamMedis->first()->obats->isNotEmpty())
                    @foreach ($kunj->rekamMedis->first()->obats as $obat)
                        {{ $obat->obat }} - Jumlah: {{ $obat->pivot->jumlah }}<br>
                    @endforeach
                @else
                    Tidak ada obat yang terkait <br>
                @endif
                <strong>Peralatan:</strong><br>
                @if ($kunj->rekamMedis->first()->peralatans->isNotEmpty())
                    @foreach ($kunj->rekamMedis->first()->peralatans as $peralatan)
                        {{ $peralatan->nama_peralatan }}<br>
                    @endforeach
                @else
                    Tidak ada peralatan yang terkait <br>
                @endif
                <strong>Gambar:</strong><br>
                @if ($kunj->rekamMedis->first()->images->isNotEmpty())
                    @foreach ($kunj->rekamMedis->first()->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" height="150" width="120" class="mb-2" alt="Gambar"><br>
                    @endforeach
                @else
                    Tidak ada gambar yang terkait <br>
                @endif
                 <strong>Total Harga Keseluruhan:</strong> Rp{{ number_format($totalObat + $kunj->rekamMedis->first()->peralatans->sum('harga'), 0, ',', '.') }} <br>
            `;

                                        // Show SweetAlert
                                        Swal.fire({
                                            title: 'Detail Rekam Medis',
                                            html: content,
                                            showCloseButton: true,
                                            confirmButtonText: 'Close',
                                            width: '50%',
                                            padding: '20px',
                                            didOpen: () => {
                                                // Prevent page scrolling when the SweetAlert is open
                                                document.body.style.overflow = 'hidden';
                                            },
                                            didClose: () => {
                                                // Allow page scrolling back when the SweetAlert is closed
                                                document.body.style.overflow = 'auto';
                                            }
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- footer template --}}
    <footer id="contact" class="footer light-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">AllCare</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <!-- Menggunakan data dari footer saya -->
                        <p>Klinik Sehat Bersama</p>
                        <p>Jalan Kebahagiaan No. 123, Kota Sejahtera, 45678</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>021-123-4567</span></p>
                        <p><strong>Email:</strong> <span>info@kliniksehat.com</span></p>
                    </div>
                    {{-- <div class="social-links d-flex mt-4">
                        <!-- Menggunakan data dari footer saya -->
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i> <span>youtube</span></a>
                        <a href="#" title="Facebook"><i class="fab fa-facebook"></i> <span>facebook</span></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i>
                            <span>instagram</span></a>
                    </div> --}}
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
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>


    {{-- footer saya --}}
    {{-- <footer>
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
    </footer> --}}
</body>

</html>
