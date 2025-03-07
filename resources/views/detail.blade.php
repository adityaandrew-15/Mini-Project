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
    <style>
        .teks-kekurangan {
            display: inline-block;
            /* Mengatur agar span tidak terbungkus ke bawah */
            width: 100%;
            /* Lebar 100% dari parent (card) */
            white-space: nowrap;
            /* Agar teks tidak terbungkus ke baris baru */
            overflow: hidden;
            /* Menyembunyikan teks yang melebihi batas */
            text-overflow: ellipsis;
            /* Menambahkan titik-titik jika teks melebihi batas */
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
            color: #727272;
            transition: 0.3s ease-in-out;
            pointer-events: none;
            top: -8px;
        }
    </style>
</head>

<body>
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
    <section id="patien-info" style="min-height: 100vh;" class="featured-services section">
        <div class="container section-title aos-init aos-animate">
            <h2>
                Riwayat Kunjungan Anda
            </h2>
        </div>
        <div class="container" style="min-height: 100vh;">
            <div class="row mb-4">
                <div class="col-4 form-group">
                    <input type="text" id="searchNama" class="form-control mt-2"
                        placeholder="Cari berdasarkan nama pasien...">
                    <label for="searchNama">Cari Nama Pasien</label>
                </div>
                <div class="col-2 form-group">
                    <select id="statusFilter" class="form-control mt-2">
                        <option value="">Semua Status</option>
                        <option value="UNDONE">UNDONE</option>
                        <option value="DONE">DONE</option>
                        <option value="PENDING">PENDING</option>
                        <option value="REJECT">REJECT</option>
                    </select>
                    <label for="statusFilter">Status</label>
                </div>
                <div class="col-2 form-group">
                    <input type="date" id="startDate" class="form-control mt-2">
                    <label for="startDate">Dari Tanggal</label>
                </div>
                <div class="col-2 form-group">
                    <input type="date" id="endDate" class="form-control mt-2">
                    <label for="endDate">Sampai Tanggal</label>
                </div>
                <div class="col-2 form-group">
                    <button id="clearFilter" class="btn btn-danger mt-2">Clear Filter</button>
                </div>
                {{-- <div class="text-end mt-4 mb-4"> --}}
                {{-- <a href="{{ route('home') }}" class="cta-btn">Kembali</a> --}}
                {{-- </div> --}}
            </div>
            @if ($kunjunganhistory->isEmpty())
                <span>Tidak Ada Data</span>
            @else
                <div class="row gy-4" id="kunjunganList">
                    @foreach ($kunjunganhistory as $kunj)
                        <div class="col-md-6 kunjungan-item" data-nama="{{ strtolower($kunj->pasien->nama) }}"
                            data-tanggal="{{ $kunj->tanggal_kunjungan }}" data-status="{{ $kunj->status }}">
                            <div class="service-item position-relative" style="overflow: hidden;">
                                <h4 style="margin: 1rem 0;">
                                    <i class="fas fa-user"></i>
                                    <span><strong>Nama :</strong></span>
                                    <span class="value">{{ $kunj->pasien->nama }}</span>
                                </h4>
                                <p style="margin: 1rem 0;">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><strong>Dokter :</strong></span>
                                    <span
                                        class="value">{{ $kunj->dokter->nama ?? 'tunggu beberapa saat lagi' }}</span>
                                </p>
                                <p style="margin: 1rem 0;">
                                    <i class="fas fa-phone"></i>
                                    <span><strong>Keluhan :</strong></span><br>
                                    <span class="value teks-kekurangan">{{ $kunj->keluhan }}</span>
                                </p>
                                <p style="margin: 1rem 0;">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span><strong>Tanggal Kunjungan :</strong></span>
                                    <span class="value">{{ $kunj->tanggal_kunjungan }}</span>
                                </p>
                                <p style="margin: 1rem 0;">
                                    <i class="fas fa-info-circle"></i>
                                    <span><strong>Status :</strong></span>
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
                                </p>
                                {{-- @if ($kunj->rekamMedis->isNotEmpty()) --}}
                                <div class="mt-3">
                                    <a href="{{ route('homedetails', $kunj->id) }}" class="cta-btn">detail</a>
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
        <div class="pagination-container">
            {{ $kunjunganhistory->links('vendor.pagination.custom') }}
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const searchNama = document.getElementById("searchNama");
                const startDate = document.getElementById("startDate");
                const endDate = document.getElementById("endDate");
                const statusFilter = document.getElementById("statusFilter");
                const clearButton = document.getElementById("clearFilter");
                const kunjunganItems = document.querySelectorAll(".kunjungan-item");

                function filterData() {
                    const searchText = searchNama.value.toLowerCase();
                    const start = startDate.value;
                    const end = endDate.value;
                    const status = statusFilter.value;

                    kunjunganItems.forEach(item => {
                        const nama = item.getAttribute("data-nama");
                        const tanggal = item.getAttribute("data-tanggal");
                        const statusItem = item.getAttribute("data-status");

                        const matchesNama = nama.includes(searchText);
                        const matchesDate = (!start || tanggal >= start) && (!end || tanggal <= end);
                        const matchesStatus = !status || statusItem === status;

                        if (matchesNama && matchesDate && matchesStatus) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    });
                }

                searchNama.addEventListener("input", filterData);
                startDate.addEventListener("change", filterData);
                endDate.addEventListener("change", filterData);
                statusFilter.addEventListener("change", filterData);

                // Fungsi untuk mereset filter dan menampilkan semua data kembali
                clearButton.addEventListener("click", function() {
                    searchNama.value = "";
                    startDate.value = "";
                    endDate.value = "";
                    statusFilter.value = "";
                    filterData();
                });
            });
        </script>
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
