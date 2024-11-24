@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Rekam Medis</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Daftar Rekam Medis</h1>
        @if(session('success'))
        <script>
            Swal.fire('Success', '{{ session('success') }}', 'success');
        </script>
        @endif

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
            + Tambah Rekam Medis
        </button>

        <!-- Search Form -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('rekam_medis.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Rekam Medis..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        @if(request('search'))
                        <a href="{{ route('rekam_medis.index') }}" class="btn btn-outline-danger">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>


        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Rekam Medis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('rekam_medis.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label for="kunjungan" class="col-sm-2 col-form-label">Kunjungan</label>
                                <div class="col-sm-10">
                                    <select name="kunjungan_id" id="kunjungan_id" class="form-control">
                                        <option>--- Pilih Pasien ---</option>
                                        @foreach ($kunjungans as $kn)
                                        <option value="{{$kn->id}}">{{$kn->pasien->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kunjungan_id')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="diagnosa" class="col-sm-2 col-form-label">Diagnosa</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="diagnosa" name="diagnosa" value="{{ old('diagnosa') }}">
                                </div>
                                @error('diagnosa')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="tindakan" class="col-sm-2 col-form-label">Tindakan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tindakan" name="tindakan" value="{{ old('tindakan') }}">
                                </div>
                                @error('tindakan')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Input for Create Modal -->
                            <div class="mb-3 row">
                                <label for="image" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                                @error('image')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kunjungan</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekamMedis as $rm)
                <tr>
                    <td>{{ $rm->kunjungan->pasien->nama }}</td>
                    <td>{{ $rm->diagnosa }}</td>
                    <td>{{ $rm->tindakan }}</td>
                    <td>
                        @if($rm->image)
                            <img src="{{ asset('storage/rekam_medis/'.$rm->image) }}" height="100px" width="80px" alt="gambar">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    
                    <td>
                        <form action="{{ route('rekam_medis.destroy', $rm->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $rm->id }}">
                            Edit
                        </button>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $rm->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $rm->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $rm->id }}">Edit Rekam Medis</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('rekam_medis.update', $rm->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="kunjungan" class="col-sm-2 col-form-label">Kunjungan</label>
                                        <div class="col-sm-10">
                                            <select name="kunjungan_id" id="kunjungan_id" class="form-control">
                                                <option value="{{ $rm->kunjungan_id }}">{{ $rm->kunjungan->pasien->nama }}</option>
                                                @foreach ($kunjungans as $kn)
                                                <option value="{{ $kn->id }}">{{ $kn->pasien->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('kunjungan_id')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="diagnosa" class="col-sm-2 col-form-label">Diagnosa</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="diagnosa" name="diagnosa" value="{{ $rm->diagnosa }}">
                                        </div>
                                        @error('diagnosa')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tindakan" class="col-sm-2 col-form-label">Tindakan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tindakan" name="tindakan" value="{{ $rm->tindakan }}">
                                        </div>
                                        @error('tindakan')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Image Input for Edit Modal -->
                                    <div class="mb-3 row">
                                        <label for="image" class="col-sm-2 col-form-label">Image</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                        @error('image')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $rekamMedis->links() }}
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@endsection
