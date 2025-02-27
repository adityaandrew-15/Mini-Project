@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="container">
        <div class="ml-5 mr-2">
            <h2 class="text-center my-2">Selesaikan Pembayaran</h2>

            <div class="card w-50">
                <div class="card-body">
                    <h4>Detail Pembayaran</h4>
                    <table class="table">
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

                    <h4>Detail Fasilitas</h4>
                    <table class="table">
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
                                    <td>Rp {{ number_format($peralatan->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h3 class="text-end">Total: Rp {{ number_format($totalHarga, 0, ',', '.') }}</h3>
                </div>
            </div>

            <h3 class="my-4 text-center">Konfirmasi Pembayaran</h3>

            <div class="d-flex justify-content-center gap-3">
                <button class="btn-add" onclick="showPaymentOptions()" style="margin-right: 10px;">Konfirmasi
                    Pembayaran</button>
                <a href="{{ route('pendingnota', $rekamMedis->id) }}" class="btn-close">Kembali</a>
            </div>
        </div>
    </div>

    <script>
        function showPaymentOptions() {
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
                    if (result.value === 'transfer') {
                        showTransferOptions();
                    } else {
                        confirmPayment('cash');
                    }
                }
            });
        }

        function showTransferOptions() {
            Swal.fire({
                title: 'Pilih Metode Transfer',
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
                if (result.isConfirmed && result.value) {
                    confirmPayment(result.value);
                }
            });
        }

        function confirmPayment(method) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: `Selesaikan pembayaran sebesar Rp {{ number_format($totalHarga, 0, ',', '.') }} dengan ${method.toUpperCase()}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Bayar Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    completePayment(method);
                }
            });
        }

        function completePayment(method) {
            $.ajax({
                url: "{{ route('kunjungan.updateStatus', $rekamMedis->id) }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    method: method
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Pembayaran Berhasil',
                        text: 'Pembayaran telah selesai!',
                        icon: 'success',
                        confirmButtonText: 'Lihat Nota',
                    }).then(() => {
                        window.location.href = "{{ route('pendingnota', $rekamMedis->id) }}";
                    });
                },
                error: function() {
                    Swal.fire('Error', 'Terjadi kesalahan, coba lagi.', 'error');
                }
            });
        }
    </script>
@endsection
