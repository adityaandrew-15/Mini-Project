@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Transfer via {{ $bank }}</h2>

    <div class="card">
        <div class="card-body">
            <p>Silakan lakukan transfer ke rekening berikut:</p>
            <p><strong>Bank:</strong> {{ $bank }}</p>
            <p><strong>No. Rekening:</strong> 123-456-789</p>
            <p><strong>Atas Nama:</strong> Klinik Sehat</p>

            <form id="payment-form">
                @csrf
                <input type="hidden" name="rekamMedis_id" value="{{ $rekamMedis->id }}">
                <input type="hidden" name="totalHarga" value="{{ $totalHarga }}">
                <input type="hidden" name="metode" value="transfer">
                <input type="hidden" name="bank" value="{{ $bank }}">

                <button type="button" class="btn btn-success btn-block mt-2" onclick="confirmPayment()">Konfirmasi Pembayaran</button>
            </form>
        </div>
    </div>
</div>
@endsection
