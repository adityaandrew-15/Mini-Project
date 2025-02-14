@extends('layouts.sidebar')


<style>
    .container {
        width: 800px;
        margin: 30px auto;
        padding: 20px;
        border-radius: 8px;
    }

    .text-center {
        text-align: center;
    }

    .wrap {
        display: flex;
        justify-content: space-between
    }

    .title-nota {
        color: #0F8CA9;
    }

    .wrap-total {
        display: flex;
        justify-content: flex-end;
    }

    @media print {
        @page {
            margin: 2rem;
            /* Hapus margin halaman */
        }

        body {
            margin: 2rem;
            /* Hapus margin body */
        }
    }
</style>
@section('side')
    <div class="container">
        <div class="nota">
            <h1 class="text-center" style="color: #0F8CA9">KLINIK</h1>
            <p class="text-center">Alamat: Alamat Klinik</p>
            <p class="text-center">Email: klinik@gmail.com</p>
            <p class="text-center">Phone: 0812-3456-7890</p>
            <hr class="my-1">
            <div class="wrap">
                <div class="wrap-title">
                    <h2 class="title-nota">Nota Pembayaran</h2>
                    <p><strong>Tanggal Transaksi:</strong> {{ $rekamMedis->kunjungan->tanggal_kunjungan }}</p>
                </div>
                <div class="wrap-data">
                    <p style="font-weight: bolder"> <strong>penerima :</strong></p>
                    <p> <span style="font-weight: bold">Nama Pasien:</span> {{ $rekamMedis->kunjungan->pasien->nama }}
                    </p>
                    <p>alamat: Alamat pasien</p>
                </div>
            </div>
            <hr class="my-1">
            <h2 class="f-bolder my-1">Detail Obat</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Obat</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis->obats as $index => $obat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $obat->obat }}</td>
                            <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            <td>{{ $obat->pivot->jumlah }}</td>
                            <td>Rp {{ number_format($obat->harga * $obat->pivot->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h2 class="f-bolder my-1">Detail Fasilitas</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Fasilitas</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis->peralatans as $index => $peralatan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $peralatan->nama_peralatan }}</td>
                            <td colspan="3">Rp {{ number_format($peralatan->harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="wrap-total my-1">
                <div class="notatal">
                    <h4 class="total">Total Harga: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>
                    <hr>
                </div>
            </div>
        </div>
        <hr class="my-2">
        @if (auth()->user()->hasRole('admin|dokter'))
            <div class="warp-total" style="display: flex;">
                <a href="{{ route('pendingdetails', $rekamMedis->kunjungan->id) }}" class="btn-close"
                    style="margin-right: 5px;">Kembali</a>
                {{-- <a onclick="window.print()" class="btn-add">
                        Cetak Nota</a> --}}
                {{-- <a onclick="cetakNota()" class="btn-add">Cetak Nota</a> --}}

                <script>
                    function cetakNota() {
                        let originalContent = document.body.innerHTML;
                        let printContent = document.querySelector('.nota').innerHTML;

                        document.body.innerHTML = printContent;
                        window.print();
                        document.body.innerHTML = originalContent;
                        location.reload(); // Refresh untuk mengembalikan tampilan awal
                    }
                </script>

                {{-- <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.4999 0.75H4.49992V4.41667H15.4999M16.4166 9C16.1735 9 15.9403 8.90342 15.7684 8.73151C15.5965 8.55961 15.4999 8.32645 15.4999 8.08333C15.4999 7.84022 15.5965 7.60706 15.7684 7.43515C15.9403 7.26324 16.1735 7.16667 16.4166 7.16667C16.6597 7.16667 16.8929 7.26324 17.0648 7.43515C17.2367 7.60706 17.3333 7.84022 17.3333 8.08333C17.3333 8.32645 17.2367 8.55961 17.0648 8.73151C16.8929 8.90342 16.6597 9 16.4166 9ZM13.6666 15.4167H6.33325V10.8333H13.6666M16.4166 5.33333H3.58325C2.85391 5.33333 2.15443 5.62306 1.63871 6.13879C1.12298 6.65451 0.833252 7.35399 0.833252 8.08333V13.5833H4.49992V17.25H15.4999V13.5833H19.1666V8.08333C19.1666 7.35399 18.8769 6.65451 18.3611 6.13879C17.8454 5.62306 17.1459 5.33333 16.4166 5.33333Z"
                                fill="white" />
                        </svg> --}}
            </div>
        @else
            <a href="{{ route('home') }}" class="btn-add">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Beranda
            </a>
        @endif

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endsection
