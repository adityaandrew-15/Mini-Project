@extends('layouts.sidebar')
<style></style>
@section('side')
    <div class="ml-3 mr-3">
        <div class="d-flex m-2 a-center">
            <div class="d-flex j-between w-100 a-center mx-2">
                <h2 class="h2 f-bolder mr-4">Data Obat</h2>
                <div class="btn"></div>
                @if (auth()->user()->hasRole('admin'))
                    <button type="button" class="btn-add main-color-hover" id="btnOpenAddModal">
                        Tambah Obat
                    </button>
                @endif
            </div>
        </div>
        <hr class="mr-3 ml-3">
        <div class="content-table m-2 d-flex col">
            <div class="d-flex">
                <div class="d-flex col mr-1 w-100">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Nama
                        Obat</label>
                    <input class="search-container w-100 h4" type="text" id="searchInput"
                        class="search-container w-100
                        h4"" class="h4" placeholder="Cari obat..."
                        class="form-control h4">
                </div>
                <div class="d-flex col mr-1 w-100">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Harga
                        Minimal</label>
                    <input class="search-container w-100 h4" type="number" id="priceMin" class="h4"
                        placeholder="Harga minimum" class="form-control">
                </div>
                <div class="d-flex col mr-1 w-100">
                    <label for=""
                        style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;">Harga
                        Maksimal</label>
                    <input type="number" class="search-container w-100 h4" id="priceMax" class="h4"
                        placeholder="Harga maksimum" class="form-control">
                </div>
                <div class="filter-form d-flex  col mr-1">
                    <label style="position: relative; left: 20px; bottom: 10px; font-size: 16px; font-weight: 600;"
                        for=""></label>
                    <button type="submit" class="btn-search"><i class="fa-regular fa-magnifying-glass"></i></button>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let searchInput = document.getElementById("searchInput");
                    let priceMin = document.getElementById("priceMin");
                    let priceMax = document.getElementById("priceMax");
                    let tableRows = document.querySelectorAll("tbody tr");

                    function filterTable() {
                        let query = searchInput.value.toLowerCase();
                        let minPrice = parseFloat(priceMin.value) || 0;
                        let maxPrice = parseFloat(priceMax.value) || Infinity;

                        tableRows.forEach(row => {
                            let obatName = row.children[0].textContent.toLowerCase();
                            let price = parseFloat(row.children[2].textContent.replace("Rp.", "")) || 0;

                            let matchesSearch = obatName.includes(query);
                            let matchesPrice = price >= minPrice && price <= maxPrice;

                            if (matchesSearch && matchesPrice) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        });
                    }

                    searchInput.addEventListener("input", filterTable);
                    priceMin.addEventListener("input", filterTable);
                    priceMax.addEventListener("input", filterTable);
                });
            </script>

            <div class="outer-table">
                <div class="content-table-table">
                    <table>
                        <thead class="h4 f-bolder">
                            <tr>
                                <th>Obat</th>
                                <th>Jumlah</th>
                                <th>harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obats as $obt)
                                <tr>
                                    <td>{{ $obt->obat }}</td>
                                    <td>{{ $obt->jumlah }}</td>
                                    <td>Rp.{{ $obt->harga }}</td>
                                    <td class="action-icons">
                                        <button type="button" style="border: none; outline: none; background: transparent;"
                                            onclick="btnOpenEditModal({{ $obt->id }})">
                                            <i class="fas fa-edit edit h3 mr-1 main-color pointer"></i>
                                        </button>
                                        <form id="delete-form-{{ $obt->id }}"
                                            action="{{ route('obat.destroy', $obt->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                style="background: transparent; outline: none; border: none"
                                                onclick="confirmDelete({{ $obt->id }})">
                                                <i class="fas fa-trash delete h3 mr-1 red pointer"></i>
                                            </button>
                                        </form>

                                        <script>
                                            function confirmDelete(id) {
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
                                                        document.getElementById('delete-form-' + id).submit();
                                                    }
                                                });
                                            }
                                        </script>
                                    </td>
                                </tr>
                                <div class="modal animate__fadeIn" id="myModalEdit{{ $obt->id }}">
                                    <div class="modal-content animate__animated animate__zoomIn">
                                        <h2 class="h2 f-bolder">Edit Obat</h2>
                                        <form action="{{ route('obat.update', $obt->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="my-2">
                                                <label for="obat" class="h4 f-bolder">Obat</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="obat" name="obat" value="{{ $obt->obat }}">
                                                </div>
                                                @error('obat')
                                                    <script>
                                                        < p style = "color: red" > {{ $message }} < /p>
                                                    </script>
                                                @enderror
                                            </div>
                                            <div class="my-2">
                                                <label for="Jumlah" class="h4 f-bolder">Jumlah</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="jumlah" name="jumlah" value="{{ $obt->jumlah }}">
                                                </div>
                                                @error('jumlah')
                                                    <script>
                                                        < p style = "color: red" > {{ $message }} < /p>
                                                    </script>
                                                @enderror
                                            </div>
                                            <div class="my-2">
                                                <label for="harga" class="h4 f-bolder">Harga</label>
                                                <div class="my-1">
                                                    <input type="text"
                                                        class="form h4 f-normal px-2 w-100 h-3 border-radius-1"
                                                        id="harga" name="harga" value="{{ $obt->harga }}">
                                                </div>
                                                @error('harga')
                                                    <script>
                                                        < p style = "color: red" > {{ $message }} < /p>
                                                    </script>
                                                @enderror
                                            </div>
                                            <button type="button" class="btn-close red-hover"
                                                onclick="closeEditModal({{ $obt->id }})">Batal</button>
                                            <button type="submit" class="btn-add main-color-hover">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container">
                    {{ $obats->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
        <div class="modal animate__animated" id="myModalAdd">
            <div class="modal-content animate__animated animate__zoomIn">
                <h2 class="h2 f-bolder">Tambah Obat</h2>
                <form action="{{ route('obat.store') }}" method="POST">
                    @csrf
                    <div class="my-2">
                        <label for="obat" class="h4 f-bolder">Obat</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="obat"
                                name="obat" value="{{ old('obat') }}">
                        </div>
                        @error('obat')
                            <script>
                                < p style = "color: red" > {{ $message }} < /p>
                            </script>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="Jumlah" class="h4 f-bolder">Jumlah</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="jumlah"
                                name="jumlah" value="{{ old('jumlah') }}">
                        </div>
                        @error('jumlah')
                            <script>
                                < p style = "color: red" > {{ $message }} < /p>
                            </script>
                        @enderror
                    </div>
                    <div class="my-2">
                        <label for="harga" class="h4 f-bolder">Harga</label>
                        <div class="my-1">
                            <input type="text" class="form h4 f-normal px-2 w-100 h-3 border-radius-1" id="harga"
                                name="harga" value="{{ old('harga') }}">
                        </div>
                        @error('harga')
                            <script>
                                < p style = "color: red" > {{ $message }} < /p>
                            </script>
                        @enderror
                    </div>

                    <button type="button" id="btnCloseAddModal" class="btn-close red-hover">Batal</button>
                    <button type="submit" id="btnCloseAddModal" class="btn-add main-color-hover">Simpan</button>
                </form>
            </div>
        </div>

        <script>
            var addModal = document.getElementById("myModalAdd");
            var btnOpenAddModal = document.getElementById("btnOpenAddModal");
            var btnCloseAddModal = document.getElementById("btnCloseAddModal");

            var editModal = document.getElementById("myModalEdit");
            var btnCloseEditModal = document.getElementById("btnCloseEditModal")

            btnOpenAddModal.onclick = function() {
                addModal.style.display = "block";
            }

            btnCloseAddModal.onclick = function() {
                addModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    addModal.style.display = "none";
                }
            }

            function btnOpenEditModal(id) {
                var modal = document.getElementById("myModalEdit" + id);
                modal.style.display = "block";
            }

            function closeEditModal(id) {
                var modal = document.getElementById("myModalEdit" + id);
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                var modals = document.querySelectorAll('.modal');
                modals.forEach(function(modal) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                });
            }

            document.addEventListener("DOMContentLoaded", function() {
                let searchInput = document.getElementById("searchInput");
                let priceMin = document.getElementById("priceMin");
                let priceMax = document.getElementById("priceMax");
                let tableBody = document.querySelector("tbody");

                searchInput.addEventListener("input", filterTable);
                priceMin.addEventListener("input", filterTable);
                priceMax.addEventListener("input", filterTable);

                function filterTable() {
                    let query = searchInput.value.toLowerCase();
                    let minPrice = parseFloat(priceMin.value) || 0;
                    let maxPrice = parseFloat(priceMax.value) || Infinity;

                    let rows = tableBody.querySelectorAll("tr");

                    rows.forEach(row => {
                        let obatName = row.children[0].textContent.toLowerCase();
                        let price = parseFloat(row.children[2].textContent.replace("Rp.", "").replace(",",
                            "")) || 0;

                        let matchesSearch = obatName.includes(query);
                        let matchesPrice = price >= minPrice && price <= maxPrice;

                        row.style.display = (matchesSearch && matchesPrice) ? "" : "none";
                    });
                }
            });
        </script>
    </div>
@endsection
