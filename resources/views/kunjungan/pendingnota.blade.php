@extends('layouts.sidebar')
<style>
    .container {
        width: 800px;
        margin: 30px 5rem;
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
        color: var(--main-color);
        font-weight: 900;
        font-size: 2rem;
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
            <hr class="my-1">
            <div class="wrap">
                <div class="wrap-title">
                    <h2 class="title-nota mb-1">Detail Pembayaran</h2>
                    <p> <span style="font-weight: bold">Nama Pasien:</span> {{ $rekamMedis->kunjungan->pasien->nama }}
                    </p>
                    <p><span style="font-weight: bold">alamat:
                        </span>{{ $rekamMedis->kunjungan->pasien->alamat ?? 'Tidak ada' }}</p>
                    <p><strong>Tanggal Kunjungan:</strong> {{ $rekamMedis->kunjungan->tanggal_kunjungan }}</p>
                </div>
                {{-- <div class="wrap-data">
                    <p style="font-weight: bolder"> <strong>penerima :</strong></p>
                    <p> <span style="font-weight: bold">Nama Pasien:</span> {{ $rekamMedis->kunjungan->pasien->nama }}
                    </p>
                    <p>alamat: {{ $rekamMedis->kunjungan->pasien->alamat ?? 'Tidak ada' }}</p>
                </div> --}}
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
                        <th width="100px">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis->obats as $index => $obat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $obat->obat }}</td>
                            <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                            <td>{{ $obat->pivot->jumlah }}</td>
                            <td width="100px">Rp {{ number_format($obat->harga * $obat->pivot->jumlah, 0, ',', '.') }}</td>
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
                        <th width="100px">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis->peralatans as $index => $peralatan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $peralatan->nama_peralatan }}</td>
                            <td colspan="3" width="100px">Rp {{ number_format($peralatan->harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div class="wrap-total my-1">
                <div class="notatal" style="justify-content: space-between; display: flex; width: 100%;">
                    <h4 class="total">Total Harga : </h4>
                    <h4> Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>
                </div>
                <hr>
            </div>
        </div>
        <hr class="my-2">
        @if (auth()->user()->hasRole('admin|dokter'))
            <div class="warp-total">
                <a href="{{ route('pendingdetails', $rekamMedis->kunjungan->id) }}" class="btn-close"
                    style="margin-right: 5px;">Kembali</a>
                @if (auth()->user()->hasRole('admin'))
                    <button class="btn-add" onclick="confirmPayment()">Konfirmasi Pembayaran</button>
                @endif
            </div>
        @else
            <a href="{{ route('home') }}" class="btn-close">
                {{-- <i class="bi bi-arrow-left"></i> --}}
                Kembali
            </a>
            <a onclick="cetakNota()" class="btn-add">Cetak Nota</a>
        @endif
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmPayment() {
            Swal.fire({
                title: 'Pilih Metode Pembayaran',
                input: 'select',
                inputOptions: {
                    'cash': 'Cash',
                    'transfer': 'Transfer'
                },
                inputPlaceholder: 'Pilih metode pembayaran',
                showCancelButton: true,
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let method = result.value;

                    if (method === 'cash') {
                        confirmCashPayment();
                    } else {
                        confirmTransferPayment();
                    }
                }
            });
        }

        function confirmCashPayment() {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Selesaikan pembayaran sebesar Rp {{ number_format($totalHarga, 0, ',', '.') }} dengan cash?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Bayar Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    processPayment('cash');
                }
            });
        }

        function confirmTransferPayment() {
            Swal.fire({
                title: 'Pilih Bank untuk Transfer',
                input: 'select',
                inputOptions: {
                    'BCA': 'BCA - 1234567890',
                    'Mandiri': 'Mandiri - 0987654321',
                    'BRI': 'BRI - 5678901234'
                },
                inputPlaceholder: 'Pilih bank',
                showCancelButton: true,
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    processPayment(result.value);
                }
            });
        }

        function processPayment(method) {
            fetch("{{ route('kunjungan.updateStatus', $rekamMedis->kunjungan->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        method: method
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Pembayaran Berhasil!',
                            text: 'Pembayaran telah diselesaikan.',
                            icon: 'success',
                            confirmButtonText: 'Lihat Nota'
                        }).then(() => {
                            window.location.href =
                                "{{ route('rekam_medis.nota', $rekamMedis->id) }}";
                        });
                    } else {
                        Swal.fire('Error', data.error, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Terjadi kesalahan, coba lagi.', 'error');
                });
        }
    </script>
@endsection
