<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title></title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/globaladmin.css') }}">
    {{-- <link href="Medicio/assets/css/main.css" rel="stylesheet"> --}}

    <!-- Vendor CSS Files -->
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
                            <h6>Welcome</h2>
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
            @yield('side')
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
