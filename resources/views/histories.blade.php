@extends('layouts.sidebar')
<style>
    .filter-container {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }
</style>
@section('side')
    <div class="mr-3 ml-3">
        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center mx-2">
                <h2 class="h2 f-bolder mr-4">Data Kunjungan</h2>
                <div class="btn"></div>
            </div>
        </div>
        <hr class="mr-3 ml-3">
        <div class="content-table m-2 d-flex col">
            <div class="filter-container" style="justify-content: flex-end;">
                <div class="d-flex w-100 col" style="border-radius: 0;">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Jenis</label>
                    <select id="filter-type" class="search-container h4 w-100">
                        <option value="">Semua Jenis</option>
                        <option value="medicine">Obat</option>
                        <option value="equipment">Peralatan</option>
                        <option value="medication">Rekam Medis</option>
                        <option value="payment">Pembayaran</option>
                    </select>
                </div>
                <div class="d-flex col">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Dari</label>
                    <input type="date" id="start-date" class="search-container h4">
                </div>
                <div class="d-flex col">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Sampai</label>
                    <input type="date" id="end-date" class="search-container h4">
                </div>
            </div>
            <input type="hidden" class="search-container w-75 h4" id="search" name="search" placeholder="Cari Riwayat"
                value="{{ request('search') }}" class="form-control">
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
                        <tbody id="history-table">
                            @foreach ($histories as $history)
                                <tr class="history-row" data-type="{{ $history->type }}"
                                    data-date="{{ $history->created_at->format('Y-m-d') }}">
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

                                                <strong>Medicines Used:</strong><br>
                                                @foreach ($history->details['obats'] as $obat)
                                                    <strong>{{ $obat['nama_obat'] }}</strong><br>
                                                    Quantity: -{{ $obat['jumlah'] }}<br>
                                                    Remaining Stock: {{ $obat['stok_tersisa'] }}<br><br>
                                                @endforeach

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

    <script>
        function applyFilters() {
            let type = document.getElementById('filter-type').value;
            let startDate = document.getElementById('start-date').value;
            let endDate = document.getElementById('end-date').value;
            let search = document.getElementById('search').value.toLowerCase();
            let rows = document.querySelectorAll('.history-row');

            rows.forEach(row => {
                let rowType = row.getAttribute('data-type');
                let rowDate = row.getAttribute('data-date');
                let rowText = row.innerText.toLowerCase();
                let show = true;

                if (type && rowType !== type) show = false;
                if (startDate && rowDate < startDate) show = false;
                if (endDate && rowDate > endDate) show = false;
                if (search && !rowText.includes(search)) show = false;

                row.style.display = show ? '' : 'none';
            });
        }

        document.getElementById('filter-type').addEventListener('change', applyFilters);
        document.getElementById('start-date').addEventListener('input', applyFilters);
        document.getElementById('end-date').addEventListener('input', applyFilters);
        document.getElementById('search').addEventListener('input', applyFilters);
    </script>
@endsection
