<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            /* Membesarkan ukuran teks dalam tabel */
        }

        .border-colored th,
        .border-colored td {
            border: 2px solid #0f8da97a;
            /* Border dengan warna spesifik */
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
                <p><strong>Tanggal Kunjungan:</strong> 17/08/1945</p>
            </div>
            <div class="col-md-6">
                <h2>Informasi Pasien</h2>
                <table class="table table-no-border">
                    <tr>
                        <td>Nama:</td>
                        <td>Nama Pasien</td>
                    </tr>
                    <tr>
                        <td>Diagnosa:</td>
                        <td>Hampir Mati</td>
                    </tr>
                    <tr>
                        <td>Tindakan:</td>
                        <td>
                            <ul class="mb-0">
                                <li>Pemeriksaan fisik</li>
                                <li>Serah</li>
                            </ul>
                        </td>
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
                        <tr>
                            <td>Magnesium</td>
                            <td>9 kg</td>
                        </tr>
                        <tr>
                            <td>Asam sulfat</td>
                            <td>6 l</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Resep</h2>
                <ol>
                    <li>Minum Paracetamol 3x sehari setelah makan.</li>
                    <li>Minum Amoxicillin 2x sehari setelah makan.</li>
                    <li>Minum sirup obat batuk saat batuk terasa parah.</li>
                </ol>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Peralatan</h2>
                <table class="table border-colored">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Magnesium</td>
                            <td>9 kg</td>
                        </tr>
                        <tr>
                            <td>Asam sulfat</td>
                            <td>6 l</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Bukti Medis</h2>
                <div class="d-flex gap-3">
                    <img class="img-thumbnail" src="https://placehold.co/150x100" alt="Medical proof image 1">
                    <img class="img-thumbnail" src="https://placehold.co/150x100" alt="Medical proof image 2">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
