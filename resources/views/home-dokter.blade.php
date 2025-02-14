@extends('layouts.sidebar')

<style>
    .welcome {
        display: flex;
        justify-content: space-between;
        overflow: hidden;
        width: 100%;
        height: 300px;
        background: url('/asset/img/hero2.png') no-repeat left bottom;
        background-size: cover;
        border-radius: 1.2rem;
        color: rgb(255, 255, 255);
        text-align: left;
    }

    .welcome-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: left;
    }

    .welcome img {
        width: auto;
        height: 310px;
        z-index: 5;
    }

    .profile {
        border-radius: 1.5rem;
        min-width: 550px;
        max-width: 550px;
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--main-color);
        width: 100%;
        border-radius: 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #fff;
        z-index: 2;
    }

    .profile-header i {
        font-size: 1.5rem;
        background-color: #D9D9D980;
        border-radius: 1rem;
        padding: 1rem;
        text-align: right;
    }

    .profile-info {
        display: flex;
        border: 1px solid #ccc;
        border-radius: 20px;
        align-items: center;
        width: 100%;
        height: 1500px;
        position: relative;
        top: -20px;
        background-color: white;
    }

    .profile-info a {
        border: solid 1px #ccc;
        background: var(--main-color);
        border-radius: 10px;
        text-decoration: none;
        color: #ffffff;
        padding: 5px 16px;
        transition: ease;
    }

    .profile-info a:hover {
        background: #20a0ef;
    }

    .profile-info img {
        width: 150px;
        height: auto;
        margin: 1rem 2rem 1rem 3rem;
        border-radius: 50%;
        border: 1px solid #ccc;
        object-fit: cover;
    }

    .welcome.blur {
        filter: blur(5px);
        transition: filter 0.3s ease;
    }



    .content-bottom {
        display: flex;
        justify-content: space-between;
        padding: 0 2rem 2rem 2rem;
        margin-top: 2rem;
    }

    .content-table {
        /* max-width: 1800px; */
    }

    .content-chart {
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 1rem;
        padding: 20px;
        text-align: center;
        width: 600px;
        height: 600px;
    }

    .chart-container {
        position: relative;
        width: 250px;
        height: 250px;
        margin: 3rem auto;
    }

    .legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-top: 3rem;
        margin: 2rem 2rem 0 2rem;

    }

    .legend-left,
    .legend-right {
        display: inline;
    }

    .legend-left div {
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        margin: 10px 10px;
    }

    .legend-right div {
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        margin: 10px 10px;
    }

    .legend div span {
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
    }

    .legend .mei span {
        background-color: #ff6384;
    }

    .legend .juni span {
        background-color: #36a2eb;
    }

    .legend .juli span {
        background-color: #ffce56;
    }

    .legend .agustus span {
        background-color: #4bc0c0;
    }

    .legend .september span {
        background-color: #9966ff;
    }

    .legend .oktober span {
        background-color: #ff9f40;
    }

    .legend .november span {
        background-color: #c9cbcf;
    }

    .legend .desember span {
        background-color: #7e57c2;
    }

    @media screen and (max-width: 1366px) {
        .content-header {
            max-width: 770px;
        }

        .welcome {
            height: 200px;
            border-radius: 0.8rem;
        }

        .welcome h2 {
            font-size: 2rem;
        }

        .welcome p {
            font-size: 1.2rem;
        }

        .welcome img {
            height: 200px;
        }

        .profile {
            width: 400px;
            height: 250px;
        }

        .profile-header {
            padding: 1rem;
            font-size: 0.7rem;
        }

        .profile-header h2 {
            font-size: 1.4rem;
        }

        .profile-header i {
            font-size: 1rem;
            padding: 0.5rem;
        }

        .profile-info {
            height: 1000px;
        }

        .profile-info h2 {
            font-size: 1.5rem;
        }

        .profile-info p {
            font-size: 1rem;
        }

        .profile-info a {
            padding: 2px 8px;
            font-size: 0.9rem;
        }

        .profile-info img {
            width: 100px;
        }

        .content-bottom {
            padding: 0 1rem 1rem 1rem;
            margin-top: 1rem;
        }

        .outer-table {
            width: 770px;
            height: 600px;
        }

        .content-table h2 {
            font-size: 2rem;
        }

        .content-table p {
            font-size: 1rem;
        }

        table th,
        table td {
            padding: 0.8rem 0.5rem;
            font-size: 1rem;
        }

        .content-chart {
            width: 400px;
            height: 500px;
            padding: 15px;
        }

        .chart-container {
            width: 200px;
            height: 200px;
        }

        .legend {
            margin: 1rem 1rem 0 1rem;
        }

        .legend div {
            font-size: 0.8rem;
            margin: 5px 5px;
        }

        .legend div span {
            width: 8px;
            height: 8px;
        }
    }

    /* Modal backdrop */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
    }

    /* Modal content box */
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        /* Vertically and horizontally centered */
        padding: 20px;
        border-radius: 8px;
        width: 50%;
        /* Adjust the width as needed */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

@section('side')
    <div class="ml-3">
        <div class="d-flex j-between">
            <div class="welcome drop-shadow ml-2 mt-2 mb-2">
                <div class="welcome-text ml-3 col d-flex j-center">
                    <h2 style="font-size: 2rem; font-weight: 900">Selamat Datang, Dr. {{ Auth::user()->name }}</h2>
                    <p style="font-size: 1rem; font-weight: 600">Semoga Harimu Menyenangkan</p>
                </div>
                <img src="{{ asset('asset/img/dokter.png') }}" alt="">
            </div>
            <div class="profile m-2">
                <div class="profile-header p-1">
                    <h1>Profile Saya</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background: transparent; outline: none; border: none;" id="openModal"><i
                            class="fa-solid fa-pen"></i></button>
                </div>
                @if (Auth::check())
                    <div class="profile-info drop-shadow">
                        @if ($dokter)
                            <img src="{{ $dokter->image ? asset('storage/' . $dokter->image) : asset('storage/' . Auth::user()->image) }}"
                                alt="Foto Profil">
                        @else
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Foto Profil">
                        @endif
                        <div class="profile-info-text">
                            <h2 class="h2">{{ Auth::user()->name }}</h2>
                            <p class="p4 f-bold mb-1">spesialisasi: {{ Auth::user()->spesialis }}</p>
                            <!-- Change the link to a button -->
                            <a href="#" class="f-bold" id="openProfileModal">Ubah Profil</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <div id="modal" class="modal">
            <div class="modal-content">
                <span id="closeModal" class="close">&times;</span>
                <h2>Edit Profile</h2>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Foto:</label>
                        <input type="file" id="image" name="image">
                    </div>

                    <div class="form-group">
                        <label for="spesialis">Spesialis:</label>
                        <input type="text" id="spesialis" name="spesialis"
                            value="{{ Auth::user()->spesialis ?? Auth::user()->dokter->spesialis }}" required>

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" id="closeModalButton" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <style>
            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
            }

            .modal-content {
                background-color: #ffffff;
                border-radius: 10px;
                padding: 20px;
                width: 90%;
                max-width: 400px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                animation: fadeIn 0.3s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 20px;
                text-align: center;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            input[type="text"],
            input[type="file"] {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }

            input[type="file"] {
                padding: 5px;
            }

            .btn {
                display: inline-block;
                padding: 10px 15px;
                font-size: 16px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .btn-primary {
                background-color: #007bff;
                color: white;
            }

            .btn-secondary {
                background-color: #6c757d;
                color: white;
            }

            .btn:hover {
                opacity: 0.9;
            }

            .form-actions {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }
        </style>


        <div class="content-card">
            <div class="content-bottom-top d-flex row">
                <div class="card-v bg-white col ml-2 mr-2 pl-2 pr-2 j-center d-flex drop-shadow">
                    <h2 style="font-size: 1.3rem;">Total Pasien</h2>
                    <div class="card-info d-flex p-1 row">
                        <i class="fa-solid fa-bed-pulse i2 main-color"></i>
                        <div class="card-info ml-2">
                            <h2>{{ DB::table('pasiens')->count() }}</h2>
                            </h2>
                            <p class="f-normal">Jumlah Seluruh Pasien</p>
                        </div>
                    </div>
                </div>
                <div class="card-v bg-white col ml-2 mr-2 pl-2 pr-2 j-center d-flex drop-shadow">
                    <h2 style="font-size: 1.3rem;">pasien yang sudah di periksa</h2>
                    <div class="card-info d-flex p-1 row">
                        <i class="fa-solid fa-list-check i2 main-color "></i>
                        <div class="card-info ml-2">
                            <h2>{{ $selesai }}</h2>
                            <p class="f-normal">Jumlah Seluruh Pasien yang sudah di periksa</p>
                        </div>
                    </div>
                </div>
                <div class="card-v bg-white col ml-2 mr-2 pl-2 pr-2 j-center d-flex drop-shadow">
                    <h2 style="font-size: 1.3rem;">Menunggu</h2>
                    <div class="card-info d-flex p-1 row">
                        <i class="fa-solid fa-user-clock i2 main-color"></i>
                        <div class="card-info ml-2">
                            <h2>{{ $count }}</h2>
                            </h2>
                            <p class="f-normal">pasien menunggu diperiksa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-table m-2 d-flex j-between">
            <div class="outer-table drop-shadow mr-1">
                <div class="d-flex j-between">
                    <div class="content-table-text m-1 a-center">
                        <h2 class="h2">Data Terbaru Kunjungan Pasien</h2>
                    </div>
                    <div class="m-1">
                        <form action="{{ route('home-dokter') }}" method="GET">
                            <input style="outline: none;" type="text" name="search_terbaru" placeholder="Search here..."
                                value="{{ request('search_terbaru') }}">
                            {{-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> --}}
                        </form>
                    </div>
                </div>
                <div class="content-table-table">
                    <table>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                        </tr>
                        @foreach ($kunjungans as $kun)
                            <tr>
                                <td>{{ $kun->pasien->nama }}</td>
                                <td>{{ $kun->keluhan }}</td>
                                <td style="color: red;">{{ $kun->status }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="content-chart m-1 drop-shadow">
                <h2 class="h2 f-bolder">Data Kunjungan Perbulan</h2 class="h2 f-bolder">
                <div class="chart-container">
                    <canvas id="myChart"></canvas>
                </div>

                @php
                    $total = $selesai + $count;
                    $selesaiPercent = $total > 0 ? number_format(($selesai / $total) * 100) : 0;
                    $menungguPercent = $total > 0 ? number_format(($count / $total) * 100) : 0;
                @endphp
                <div class="legend">
                    <div class="legend-left">

                        <div class="selesai"><span></span>Selesai: <span id="selesai-count"
                                style="margin-top:-10px">{{ $selesai }}</span> (<span id="selesai-percent"
                                style="margin-top: -10px">{{ $selesaiPercent }}</span>%)</div>
                        <div class="menunggu"><span></span>Menunggu: <span id="menunggu-count"
                                style="margin-top: -10px">{{ $count }}</span> (<span id="menunggu-percent"
                                style="margin-top: -10px">{{ $menungguPercent }}</span>%)</div>

                    </div>
                </div>
            </div>
        </div>
        <div class="content-table m-2">
            <div class="outer-table drop-shadow mr-1">
                <div class="d-flex j-between">
                    <div class="content-table-text m-1">
                        <h2 class="h2">Data Kunjungan Pasien</h2>
                    </div>
                    <div class="m-1">
                        <form action="{{ route('home-dokter') }}" method="GET">
                            <input style="outline: none;" type="text" name="search_kunjungan"
                                placeholder="Search here..." value="{{ request('search_kunjungan') }}">
                            {{-- <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> --}}
                        </form>
                    </div>
                </div>
                <div class="content-table-table">
                    <table>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>status</th>
                        </tr>
                        @foreach ($kunjungan as $k)
                            <tr>
                                <td>{{ $k->pasien->nama }}</td>
                                <td>{{ $k->keluhan }}</td>
                                <td style="color: green;">{{ $k->status }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <script>
            const selesai = {{ $selesai }};
            const menunggu = {{ $count }};
            const total = selesai + menunggu; // Total kunjungan

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Menunggu'],
                    datasets: [{
                        data: [selesai, menunggu],
                        backgroundColor: [
                            '#ff6384', // Warna untuk Selesai
                            '#36a2eb', // Warna untuk Menunggu
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw;
                                    label += ' (' + (context.raw / total * 100).toFixed(2) + '%)';
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Update persentase di legend
            document.getElementById('selesai-percent').textContent = (selesai / total * 100);
            document.getElementById('menunggu-percent').textContent = (menunggu / total * 100);
        </script>

        <script>
            // Dapatkan elemen
            const modal = document.getElementById('modal');
            const openModalBtn = document.getElementById('openModal');
            const openProfileModalBtn = document.getElementById('openProfileModal'); // New button
            const closeModalBtn = document.getElementById('closeModal');
            const welcomeSection = document.querySelector('.welcome'); // Select the welcome section

            // Fungsi untuk membuka modal
            const openModal = () => {
                modal.style.display = 'block';
                welcomeSection.classList.add('blur'); // Add blur class
            };

            openModalBtn.addEventListener('click', openModal);
            openProfileModalBtn.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default anchor behavior
                openModal(); // Call the open modal function
            });

            // Fungsi untuk menutup modal
            closeModalBtn.addEventListener('click', () => {
                modal.style.display = 'none';
                welcomeSection.classList.remove('blur'); // Remove blur class
            });

            // Tutup modal jika pengguna klik di luar area modal
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    welcomeSection.classList.remove('blur'); // Remove blur class
                }
            });
        </script>

        <script>
            // Dapatkan elemen
            const modal = document.getElementById('modal');
            const openModalBtn = document.getElementById('openModal'); // Button with pen icon
            const openProfileModalBtn = document.getElementById('openProfileModal'); // New button
            const closeModalBtn = document.getElementById('closeModal');
            const welcomeSection = document.querySelector('.welcome'); // Select the welcome section

            // Fungsi untuk membuka modal
            const openModal = () => {
                modal.style.display = 'block';
                welcomeSection.classList.add('blur'); // Add blur class
            };

            // Attach event listeners
            openModalBtn.addEventListener('click', openModal);
            openProfileModalBtn.addEventListener('click', (e) => {
                e.preventDefault(); // Prevent default anchor behavior
                openModal(); // Call the open modal function
            });

            // Fungsi untuk menutup modal
            closeModalBtn.addEventListener('click', () => {
                modal.style.display = 'none';
                welcomeSection.classList.remove('blur'); // Remove blur class
            });

            // Tutup modal jika pengguna klik di luar area modal
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    welcomeSection.classList.remove('blur'); // Remove blur class
                }
            });
        </script>

        <script>
            // Dapatkan elemen

            const modal = document.getElementById('modal');
            const openModalBtn = document.getElementById('openModal');
            const closeModalBtn = document.getElementById('closeModal');

            // Fungsi untuk membuka modal
            openModalBtn.addEventListener('click', () => {
                modal.style.display = 'block';
            });

            // Fungsi untuk menutup modal
            closeModalBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // Tutup modal jika pengguna klik di luar area modal
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </div>
@endsection
