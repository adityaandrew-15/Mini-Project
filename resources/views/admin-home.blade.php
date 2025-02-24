<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .welcome {
            display: flex;
            justify-content: space-between;
            overflow: hidden;
            width: 100%;
            height: 280px;
            margin: 1.5rem 0;
            background: url('/asset/img/hero2.png') no-repeat left bottom;
            background-size: cover;
            border-radius: 2rem;
            color: rgb(255, 255, 255);
            text-align: left;
        }

        .welcome::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 30%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.576), rgba(255, 255, 255, 0));
            z-index: 1;
        }

        /* .welcome-text {
            font-weight: 600;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
            padding: 1.5rem;
        } */

        /* .welcome p {
            font-size: 2rem;
            font-weight: 800;
            margin-top: 0;
        } */

        .welcome img {
            width: auto;
            height: 310px;
            z-index: 5;
        }

        .content-bottom-top {
            height: 230px;
        }

        .content-bottom-top-content {
            display: flex;
            margin-bottom: 2rem;
        }

        .content-bottom-card {
            width: 500px;
            font-size: 2rem;
            background: #fff;
            border-radius: 1rem;
            border: 1px solid #c9cbcf;
            padding: 2rem;
            margin-right: 2rem;
        }

        .content-bottom-card h2 {
            font-weight: 700;
        }

        .content-bottom-card p {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .content-bottom-card i {
            font-weight: 800;
            font-size: 8rem;
            margin: 1rem 2rem 0 0;
        }

        .content-bottom-card-content {
            display: flex;
            padding: 0 10px 10px 10px
        }

        .content-tree-chart {
            text-align: center;
            width: 1070px;
            border: 1px solid #c9cbcf;
            border-radius: 1rem;
            background: #fff;
            padding: 2rem 4rem;
        }

        .chart-tree-container {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            margin-top: 30px;
            height: 400px;
            width: 100%;
        }

        .content-tree-chart h2 {
            text-align: left;
        }

        .bar {
            position: relative;
            width: 50px;
            background-color: var(--main-color);
            transition: height 0.5s ease-in-out;
        }

        .bar-value {
            position: absolute;
            bottom: 100%;
            /* Tempatkan angka di atas batang */
            left: 50%;
            transform: translateX(-50%);
            /* Pusatkan angka */
            font-size: 14px;
            /* Ukuran font untuk angka */
            color: #000;
            /* Warna font untuk angka */
            /* background-color: rgba(0, 0, 0, 0.7); */
            /* Latar belakang semi-transparan untuk kontras */
            padding: 2px 5px;
            /* Padding untuk angka */
            border-radius: 5px;
            /* Sudut membulat untuk latar belakang */
        }

        .labels {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .labels span {
            font-size: 14px;
            color: #333;
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

        .legend .selesai span {
            background-color: #ff6384;
        }

        .legend .menunggu span {
            background-color: #36a2eb;
        }


        @media screen and (max-width: 1366px) {
            :root {
                --main-color: #0F8CA9;
            }

            body {
                font-size: 0.8rem;
            }

            .wrapper-container {
                margin-left: 7rem;
            }

            .header {
                padding: 1rem 1rem 0 1rem;
            }

            .content-header {
                width: 1210px;
            }

            .search input {
                height: 40px;
                margin: 1rem 0;
                border-radius: 0.8rem;
            }

            .search-container {
                height: 50px;
                border-radius: 1rem;
                padding: 3px 8px;
            }

            .search-container input {
                font-size: 1rem;
            }

            .welcome {
                height: 200px;
                margin: 1rem 0;
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

            .content-bottom {
                padding: 0 2rem 2rem 1rem;
            }

            .content-bottom-card {
                width: 350px;
                font-size: 1rem;
                background: #fff;
                border-radius: 1rem;
                border: 1px solid #c9cbcf;
                padding: 1rem;
                margin-right: 2rem;
            }

            .content-bottom-card h2 {
                font-size: 1.5rem;
            }

            .content-bottom-card p {
                font-weight: 600;
                font-size: 1rem;
            }

            .content-bottom-card i {
                font-size: 4rem;
            }

            .content-tree-chart {
                width: 770px;
            }

            .content-chart {
                width: 400px;
                height: 570px;
                padding: 15px;
            }

            .content-chart h1 {
                font-size: 1.5rem;
            }

            .chart-container {
                width: 300px;
                height: 300px;
                min-height: 100px;
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
    </style>
</head>
@extends('layouts.sidebar')
@section('side')
    <div class="m-3">
        <div class="m-2">
            <div class="col">
                <div class="welcome drop-shadow">
                    <div class="welcome-text ml-3 col d-flex j-center">
                        <h2 style="font-size: 2rem; font-weight: 900;">Selamat Datang Admin</h2>
                        <p style="font-size: 1rem; font-weight: 600;">Semoga Harimu Menyenangkan</p>
                    </div>
                    <img src="{{ asset('asset/img/dokter.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="content-card">
            <div class="content-bottom-top d-flex row">
                <div class="card-v bg-white col ml-2 mr-2 pl-2 pr-2 j-center d-flex drop-shadow">
                    <h2>Total Pasien</h2>
                    <div class="card-info d-flex p-1 row">
                        <i class="fa-solid fa-bed-pulse i2 main-color"></i>
                        <div class="card-info ml-2">
                            <h2>{{ DB::table('pasiens')->count() }}</h2>
                            <p>Jumlah Seluruh Pasien yang terdaftar di klinik</p>
                        </div>
                    </div>
                </div>
                <div class="card-v bg-white col ml-2 mr-2 pl-2 pr-2 j-center d-flex drop-shadow">
                    <h2>Dokter aktif</h2>
                    <div class="card-info d-flex p-1 row">
                        <i class="fa-solid fa-user-doctor i2 main-color"></i>
                        <div class="card-info ml-2">
                            <h2>{{ DB::table('dokters')->count() }}</h2>
                            <p>Jumlah Seluruh dokter yang terdaftar di klinik</p>
                        </div>
                    </div>
                </div>
                <div class="card-v bg-white col ml-2 mr-2 pl-2 pr-2 j-center d-flex drop-shadow">
                    <h2>Kunjungan Pasien</h2>
                    <div class="card-info d-flex p-1 row">
                        <i class="fa-solid fa-list-check i2 main-color "></i>
                        <div class="card-info ml-2">
                            <h2>{{ DB::table('kunjungans')->count() }}</h2>
                            <p>Total Semua Kunjungan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-end ml-2 mr-2 mb-2 d-flex">
            <div class="content-tree-chart m-1 drop-shadow">
                <h2 class="h2">Chart Batang Kunjungan Per Bulan</h2>
                <div class="chart-tree-container">
                    <div class="bar" id="jan"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 1)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 1)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="feb"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 2)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 2)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="mar"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 3)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 3)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="apr"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 4)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 4)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="may"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 5)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 5)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="jun"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 6)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 6)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="jul"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 7)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 7)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="aug"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 8)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 8)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="sep"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 9)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 9)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="oct"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 10)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 10)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="nov"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 11)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 11)->first()->jumlah ?? 0 }}</span>
                    </div>
                    <div class="bar" id="dec"
                        data-value="{{ $kunjunganPerBulan->where('bulan', 12)->first()->jumlah ?? 0 }}">
                        <span class="bar-value">{{ $kunjunganPerBulan->where('bulan', 12)->first()->jumlah ?? 0 }}</span>
                    </div>
                </div>
                <div class="labels">
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>May</span>
                    <span>Jun</span>
                    <span>Jul</span>
                    <span>Aug</span>
                    <span>Sep</span>
                    <span>Oct</span>
                    <span>Nov</span>
                    <span>Dec</span>
                </div>
            </div>
            <div class="content-chart m-1 drop-shadow">
                <h1>Chart Kunjungan Dokter</h1>
                <canvas id="dokterChart" width="400" height="400"></canvas>
            </div>
        </div>
        <script>
            // Data kunjungan per bulan
            const visitsData = {
                jan: 0,
                feb: 0,
                mar: 0,
                apr: 0,
                may: 0,
                jun: 0,
                jul: 0,
                aug: 0,
                sep: 0,
                oct: 0,
                nov: 0,
                dec: 0
            };

            // Mengisi data kunjungan dari backend
            @if (isset($kunjunganPerBulan) && $kunjunganPerBulan->isNotEmpty())
                @foreach ($kunjunganPerBulan as $kunjungan)
                    switch ({{ $kunjungan->bulan }}) {
                        case 1:
                            visitsData.jan = {{ $kunjungan->jumlah }};
                            break;
                        case 2:
                            visitsData.feb = {{ $kunjungan->jumlah }};
                            break;
                        case 3:
                            visitsData.mar = {{ $kunjungan->jumlah }};
                            break;
                        case 4:
                            visitsData.apr = {{ $kunjungan->jumlah }};
                            break;
                        case 5:
                            visitsData.may = {{ $kunjungan->jumlah }};
                            break;
                        case 6:
                            visitsData.jun = {{ $kunjungan->jumlah }};
                            break;
                        case 7:
                            visitsData.jul = {{ $kunjungan->jumlah }};
                            break;
                        case 8:
                            visitsData.aug = {{ $kunjungan->jumlah }};
                            break;
                        case 9:
                            visitsData.sep = {{ $kunjungan->jumlah }};
                            break;
                        case 10:
                            visitsData.oct = {{ $kunjungan->jumlah }};
                            break;
                        case 11:
                            visitsData.nov = {{ $kunjungan->jumlah }};
                            break;
                        case 12:
                            visitsData.dec = {{ $kunjungan->jumlah }};
                            break;
                    }
                @endforeach
            @endif

            // Fungsi untuk mengupdate tinggi batang sesuai dengan data kunjungan
            function updateChart() {
                for (let month in visitsData) {
                    let bar = document.getElementById(month);
                    let height = visitsData[month] * 2; // Mengalikan dengan 2 untuk memperbesar tinggi batang

                    // Atur tinggi batang berdasarkan data kunjungan
                    bar.style.height = height + 'px';
                }
            }

            // Panggil fungsi updateChart setelah halaman dimuat
            window.onload = updateChart;
        </script>

        <script>
            // Check the structure of dokterKunjungan
            console.log(@json($dokterKunjungan)); // This will print the data being passed

            const ctx = document.getElementById('dokterChart').getContext('2d');
            const dokterKunjungan = @json($dokterKunjungan);

            // Ensure that the data is correctly structured before using it
            const labels = dokterKunjungan.map(d => d.dokter ? d.dokter.nama : 'Unknown Doctor'); // Ensure 'dokter' exists
            const data = dokterKunjungan.map(d => d.total); // Ensure 'total' exists

            // Log the labels and data
            console.log('Labels:', labels);
            console.log('Data:', data);

            const chart = new Chart(ctx, {
                type: 'pie', // Tipe chart lingkaran
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah pasien',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Perbandingan Kunjungan Dokter'
                        }
                    }
                }
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </div>
@endsection
