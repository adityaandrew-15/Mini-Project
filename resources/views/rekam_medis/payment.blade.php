@extends($layout)

@section($content)

<!-- Payment Section -->
<h2 class="mt-5">Daftar Pembayaran</h2>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Pasien</th>
            <th>Tanggal Pembayaran</th>
            <th>Jumlah</th>
            <th>Status</th>
            @if (auth()->user()->hasRole('admin'))
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->rekamMedis->kunjungan->pasien->nama }}</td>
                <td>{{ $payment->tanggal_pembayaran }}</td>
                <td>{{ number_format($payment->jumlah, 2) }}</td>
                <td>{{ $payment->status }}</td>
                @if (auth()->user()->hasRole('admin'))
                    <td class="action-icons">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}">
                            Edit
                        </button>
                        <form id="delete-payment-form-{{ $payment->id }}" action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" class="btn btn-danger" onclick="confirmDeletePayment({{ $payment->id }})">Hapus</button>
                    </td>
                @endif
            </tr>

            <!-- Edit Payment Modal -->
            <div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editPaymentModalLabel{{ $payment->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPaymentModalLabel{{ $payment->id }}">Edit Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $payment->jumlah }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="Lunas" {{ $payment->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                        <option value="Belum Lunas" {{ $payment->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

<script>
    function confirmDeletePayment(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-payment-form-' + id).submit();
            }
        });
    }
</script>
@endsection
