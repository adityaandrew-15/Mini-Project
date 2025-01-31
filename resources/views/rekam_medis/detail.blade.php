<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Rekam Medis</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1 {
            font-weight: 900;
            color: #0F8CA9;
            font-size: 2.5rem;
        }

        h2 {
            font-weight: bold;
            font-size: 1.8rem;
        }

        p {
            font-size: 1rem;
        }

        .custom-row {
            border-top: 4px solid #0F8CA9;
            border-bottom: 2px solid #0F8CA9;
            background: linear-gradient(to right, #26a0bb3a, white);
            padding: 20px;
        }

        .custom-rows {
            border-bottom: 2px solid #0F8CA9;
        }

        table {
            font-size: 1.1rem;
        }

        .border-colored th,
        .border-colored td {
            border: 2px solid #0f8da97a;
        }

        .table-no-border {
            border: none;
        }

        .table-no-border th,
        .table-no-border td {
            border: none;
            background-color: transparent;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1>KLINIK</h1>
            <p class="mb-1">Alamat: Alamat Klinik</p>
            <p class="mb-1">Email: example@example.com</p>
            <p>Phone: 081234567890</p>
        </div>

        <div class="row align-items-center mb-4 custom-row">
            <div class="col-md-6">
                <h1>Detail Kunjungan</h1>
                <p><strong>Tanggal Kunjungan:</strong> {{ $rekamMedis->kunjungan->tanggal_kunjungan }}</p>
            </div>
            <div class="col-md-6">
                <h2>Informasi Pasien</h2>
                <table class="table table-no-border">
                    <tr>
                        <td>Nama:</td>
                        <td>{{ $rekamMedis->kunjungan->pasien->nama }}</td>
                    </tr>
                    <tr>
                        <td>Diagnosa:</td>
                        <td>{{ $rekamMedis->diagnosa }}</td>
                    </tr>
                    <tr>
                        <td>Tindakan:</td>
                        <td>{{ $rekamMedis->tindakan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mb-4 custom-rows">
            <div class="col-md-6">
                <h2>Obat</h2>
                <table class="table border-colored">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rekamMedis->obats && $rekamMedis->obats->count() > 0)
                            @foreach ($rekamMedis->obats as $obat)
                                <tr>
                                    <td>{{ $obat->obat }}</td>
                                    <td>{{ $obat->pivot->jumlah }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">Tidak ada obat yang terkait</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Resep</h2>
                <ol>
                    @if ($rekamMedis->resep)
                        <li>{{ $rekamMedis->resep->deskripsi }}</li>
                    @else
                        <li>Tidak ada resep</li>
                    @endif
                </ol>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Peralatan</h2>
                <table class="table border-colored">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Peralatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rekamMedis->peralatans && $rekamMedis->peralatans->count() > 0)
                            @foreach ($rekamMedis->peralatans as $peralatan)
                                <tr>
                                    <td>{{ $peralatan->nama_peralatan }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Tidak ada peralatan yang terkait</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Bukti Medis</h2>
                <div class="d-flex gap-3">
                    @if ($rekamMedis->images && $rekamMedis->images->count() > 0)
                        @foreach ($rekamMedis->images as $image)
                            <img class="img-thumbnail" src="{{ asset('storage/' . $image->image_path) }}" alt="Medical proof image" style="width: 150px; height: 100px;">
                        @endforeach
                    @else
                        <p>Tidak ada gambar</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>