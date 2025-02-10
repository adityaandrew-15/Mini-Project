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
    <link rel="stylesheet" href="{{ asset('css/globaladmin.css') }}">

    <!-- Vendor CSS Files -->
    {{-- <link href="Medicio/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="Medicio/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="Medicio/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
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
    <div class="app-container">
        <div class="sidebar" id="sidebar">
            <div onclick="toggleSidebar()" class="btn-toggle-sidebar">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <ul>
                <li>
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin-home') }}">
                        @elseif (auth()->user()->hasRole('dokter'))
                            <a href="{{ route('home-dokter') }}">
                    @endif
                    <img src="{{ asset('icons/logos.svg') }}" alt="">
                    <span style="font-family: 'Handlee', cursive; font-size: 24px;">ALLCARE</span>
                    </a>

                </li>
                <li>
                    <div class="gap-li"></div>
                </li>
                @if (auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin-home') }}"
                            class="{{ request()->routeIs('admin-home') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                @endif
                </li>
                <li>
                    @if (auth()->user()->hasRole('dokter'))
                        <a href="{{ route('home-dokter') }}"
                            class="{{ request()->routeIs('home-dokter') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif
                </li>


                @if (auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('dokter.index') }}"
                            class="{{ request()->routeIs('dokter.index') ? 'active' : '' }}">
                            <i class="fa fa-user-md"></i>
                            <span>Dokter</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('obat.index') }}"
                            class="{{ request()->routeIs('obat.index') ? 'active' : '' }}">
                            <i class="fa fa-pills"></i>
                            <span>Obat</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('pasien.index') }}"
                        class="{{ request()->routeIs('pasien.index') ? 'active' : '' }}">
                        <i class="fa fa-users"></i>
                        <span>Pasien</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('resep.index') }}"
                        class="{{ request()->routeIs('resep.index') ? 'active' : '' }}">
                        <i class="fa fa-notes-medical"></i>
                        <span>Diagnosis</span>
                    </a>
                </li> --}}

                <li>
                    <a href="{{ route('kunjungan.index') }}"
                        class="{{ request()->routeIs('kunjungan.index') ? 'active' : '' }}">
                        <i class="fa fa-calendar-check"></i>
                        <span>Kunjungan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('jadwal_praktek.index') }}"
                        class="{{ request()->routeIs('jadwal_praktek.index') ? 'active' : '' }}">
                        <i class="fa fa-calendar-day"></i>
                        <span>Jadwal Praktek</span>
                    </a>
                </li>

                @if (auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('peralatan.index') }}"
                            class="{{ request()->routeIs('peralatan.index') ? 'active' : '' }}">
                            <i class="bi bi-tools"></i>
                            <span>peralatan</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->hasRole('dokter'))
                    <li>
                        <a href="{{ route('riwayat') }}"
                            class="{{ request()->routeIs('riwayat') ? 'active' : '' }}">
                            <i class="bi bi-clock-history"></i>
                            <span>riwayat</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="#" class="q-btn" style="color: inherit; cursor: pointer;"
                        onclick="confirmLogout(event)">
                        <i class="fa fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

                <script>
                    function confirmLogout(event) {
                        event.preventDefault();

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Anda akan keluar dari akun ini.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, keluar!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });
                    }
                </script>

            </ul>
            <ul class="profile-sidebar">
                <li>
                    <a href="#">
                        <img class="photo-profile-sidebar" src="{{ asset('asset/img/dokter.png') }}" alt="">
                        <span>
                                @if (auth()->user()->hasRole('admin'))
                                    <p>admin</p>
                                @elseif (auth()->user()->hasRole('dokter'))
                                    <p>{{ Auth::user()->name }}</p>
                                @endif
                        </span>
                    </a>
                </li>
            </ul>
        </div>


        <div class="wrapper-container" id="wrapper-container">
        
    <section id="patien-info" class="featured-services section">
        <div class="container section-title aos-init aos-animate">
            <h2>
                Riwayat Kunjungan pasien anda
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
                                    <span class="value">{{ auth()->user()->dokter->nama }}</span>
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
                                    <div class="text-start mt-4">
                                        <a href="#" class="btn btn-info btn-sm"
                                            id="detailBtn{{ $kunj->rekamMedis->first()->id }}">
                                            <p>Detail</p>
                                        </a>
                                    </div>

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
                                @else
                                    <p>Tidak ada rekam medis untuk kunjungan ini.</p>
                                @endif
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
    </div>
    </div>
    <script src="sidebar/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="sidebar/assets/js/core/popper.min.js"></script>
    <script src="sidebar/assets/js/core/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- jQuery Scrollbar -->
    <script src="sidebar/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="sidebar/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="sidebar/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="sidebar/assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="sidebar/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="sidebar/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="sidebar/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="sidebar/assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="sidebar/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('expanded');
        }
    </script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('wrapper-container');

            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
    </script>
</body>

</html>
