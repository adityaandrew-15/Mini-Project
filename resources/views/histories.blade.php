@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="m-3">
        <div class="content-table m-2 d-flex col">
            <form method="GET" action="{{ route('dokter.index') }}" class="d-flex w-100 gap-2">
                <input type="text" class="search-container w-75 h4" name="search" placeholder="Cari Riwayat"
                    value="{{ request('search') }}" class="form-control">

                <button type="submit" class="btn-filter">Cari</button>

                <style>
                    .invisible-btn {
                        opacity: 0;
                        /* Tombol tidak terlihat */
                        position: absolute;
                        /* Menghindari layout bergeser */
                        pointer-events: none;
                        /* Mencegah klik langsung */
                    }
                </style>

            </form>
            <div class="outer-table">
                <div class="content-table-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ ucfirst($history->type) }}</td>
                                    <td>{{ ucfirst($history->action) }}</td>
                                    <td>
                                        @if ($history->type == 'medicine')
                                            @if ($history->action == 'added')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Quantity: {{ $history->details['quantity'] }}<br>
                                                Price: {{ number_format($history->details['price'], 2) }}
                                            @elseif($history->action == 'removed')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Quantity: {{ $history->details['quantity'] }}<br>
                                                Remaining Stock: {{ $history->details['remaining_stock'] }}
                                            @endif
                                        @elseif($history->type == 'equipment')
                                            @if ($history->action == 'added')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Price: {{ number_format($history->details['price'], 2) }}
                                            @elseif($history->action == 'removed')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Price: {{ number_format($history->details['price'], 2) }}
                                            @elseif($history->action == 'used')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Price: {{ number_format($history->details['price'], 2) }}
                                            @endif
                                        @elseif($history->type == 'payment')
                                            <strong>{{ $history->details['patient_name'] }}</strong><br>
                                            Total Transaction: {{ number_format($history->details['total'], 2) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
