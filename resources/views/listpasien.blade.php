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
    <section id="patien-info" class="featured-services section">
        <div class="container section-title aos-init aos-animate">
            <h2>
                Data Pasien
            </h2>
        </div>
        <div class="container" style="min-height: 100vh;">
            <div class="row mb-4">
                <div class="col-4 form-group">
                    <input type="text" id="searchNamaAlamat" class="form-control mt-2"
                        placeholder="Cari berdasarkan nama atau alamat pasien...">
                    <label for="searchNamaAlamat">Cari Nama atau Alamat Pasien</label>
                </div>
                <div class="col-2 form-group">
                    <button id="clearFilter" class="btn btn-danger mt-2">Clear Filter</button>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const searchNamaAlamat = document.getElementById("searchNamaAlamat");
                    const clearButton = document.getElementById("clearFilter");
                    const kunjunganItems = document.querySelectorAll(".kunjungan-item");

                    // Fungsi untuk filter data
                    function filterData() {
                        const searchText = searchNamaAlamat.value.toLowerCase();

                        kunjunganItems.forEach(item => {
                            const nama = item.getAttribute("data-nama");
                            const alamat = item.getAttribute("data-alamat");

                            // Cek apakah nama atau alamat mencocokkan dengan input pencarian
                            const matchesNama = nama.includes(searchText);
                            const matchesAlamat = alamat.includes(searchText);

                            if (matchesNama || matchesAlamat) {
                                item.style.display = "block"; // Tampilkan item
                            } else {
                                item.style.display = "none"; // Sembunyikan item
                            }
                        });
                    }

                    // Event listener untuk pencarian
                    searchNamaAlamat.addEventListener("input", filterData);

                    // Fungsi untuk mereset filter dan menampilkan semua data
                    clearButton.addEventListener("click", function() {
                        searchNamaAlamat.value = "";
                        filterData();
                    });
                });
            </script>

            <div class="text-end mt-4 mb-4">
                <a href="{{ route('home') }}" class="cta-btn">Kembali</a>
            </div>
            @if ($pasien->isEmpty())
                <span>Tidak Ada Data</span>
            @else
                <div class="row">
                    @foreach ($pasien as $pas)
                        <div class="col-md-4 mb-4 aos-init aos-animate kunjungan-item"
                            data-nama="{{ strtolower($pas->nama) }}" data-alamat="{{ strtolower($pas->alamat) }}">
                            <div class="service-item position-relative">
                                <h4>Data Pasien : <span class="value">{{ $pas->nama }}</span></h4>
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
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="pagination-container">
            {{ $pasien->links('vendor.pagination.custom') }}
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
