<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail riwayat</title>
    <link rel="stylesheet" href="/css/home_dashboard.css">
</head>
<body>
<section id="patien-info" class="patient-info">
        <h3>
            Riwayat Kunjungan Anda
        </h3>
        <p>
            Berikut adalah daftar kunjungan yang <br> telah Anda buat.
        </p>
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
                    <h2 style="font-weight: bold;">Data Anda: </h2>
                    <p>
                        <i class="fas fa-user"></i>
                        <span class="label">Nama :</span>
                        <span style="font-weight: bolder; color:#000;" class="value">{{ $kunj->pasien->nama }}</span>
                    </p>
                    {{-- <p>
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="label">Dokter :</span>
                        <span class="value">{{ $kunj->dokter-nama }}</span>
                    </p> --}}
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
            <div class="button-details">
                <div class="details-button">
                    <i class="fa-regular fa-eye"></i>
                    <a href="{{route ('home')}}">kembali</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>