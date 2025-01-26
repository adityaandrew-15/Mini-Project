<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail riwayat</title>
    <link rel="stylesheet" href="/css/detail.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar">
        <h1>
            KLINIK
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
                    data Kunjungan
            </a></li>

            
        </ul>
        <ul>
            <li style="margin-top: 7px">
                <a href="#">
                    <i class="fa-solid fa-inbox"></i>
                    @if (auth()->user()->unreadNotifications->count())
                        <span class="notification-badge"
                            style="color: red">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                    <p>Inbox</p>
                </a>
            </li>
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
    </nav>
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
                        <span class="value">{{$kun->dokter->nama ?? 'tunggu beberapa saat lagi'}}</span>
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