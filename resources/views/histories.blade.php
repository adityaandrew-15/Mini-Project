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
                                                Quantity : + {{ $history->details['quantity'] }}<br>
                                                Price : {{ number_format($history->details['price'], 2) }}
                                            @elseif($history->action == 'removed')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Quantity : {{ $history->details['quantity'] }}<br>
                                                Remaining Stock : {{ $history->details['remaining_stock'] }}
                                            @endif
                                        @elseif($history->type == 'equipment')
                                            @if ($history->action == 'added')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Price : {{ number_format($history->details['price'], 2) }}
                                            @elseif($history->action == 'removed')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Price : {{ number_format($history->details['price'], 2) }}
                                            @elseif($history->action == 'used')
                                                <strong>{{ $history->details['name'] }}</strong><br>
                                                Price : {{ number_format($history->details['price'], 2) }}
                                            @endif
                                        @elseif($history->type == 'payment')
                                            <strong>{{ $history->details['patient_name'] }}</strong><br>
                                            Total Transaction : Rp.{{ number_format($history->details['total'], 2) }}
                                        @elseif($history->type == 'medication')
                                            @if ($history->action == 'prescribed')
                                                <strong>Medication Prescribed</strong><br>
                                                <strong>Patient:</strong> {{ $history->details['patient_name'] }}<br>
                                                <strong>Status:</strong> {{ $history->details['status'] }}<br><br>

                                                <!-- Loop untuk obat yang berkurang -->
                                                <strong>Medicines Used:</strong><br>
                                                @foreach ($history->details['obats'] as $obat)
                                                    <strong>{{ $obat['nama_obat'] }}</strong><br>
                                                    Quantity: -{{ $obat['jumlah'] }}<br>
                                                    Remaining Stock: {{ $obat['stok_tersisa'] }}<br><br>
                                                @endforeach

                                                <!-- Loop untuk peralatan yang digunakan -->
                                                @if (!empty($history->details['peralatans']))
                                                    <strong>Equipment Used:</strong><br>
                                                    @foreach ($history->details['peralatans'] as $peralatan)
                                                        <strong>{{ $peralatan['nama_peralatan'] }}</strong><br>
                                                        Price: {{ number_format($peralatan['harga'], 2) }}<br><br>
                                                    @endforeach
                                                @endif
                                            @endif
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
