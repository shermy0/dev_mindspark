@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/kategoribuku.css') }}">
<!-- Add the DataTable CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<div class="container">
    <h2 class="mb-4">Kelola Kategori Buku</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add a class to the table -->
    <table class="bukuTable table table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bukus as $buku)
            <tr>
                <td>{{ $buku->id }}</td>
                <td>{{ $buku->NamaBuku }}</td>
                <td>
                    @foreach ($buku->kategoris as $kategori)
                        <span class="badge bg-primary">{{ $kategori->NamaKategori }}</span>
                    @endforeach
                </td>
                <td>
                    <!-- Button untuk edit kategori -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKategoriModal{{ $buku->id }}">Ubah Kategori</button>
                </td>
            </tr>

            <!-- Modal Edit Kategori -->
            <div class="modal fade" id="editKategoriModal{{ $buku->id }}" tabindex="-1" aria-labelledby="editKategoriLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kategori - {{ $buku->NamaBuku }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('buku-kategori.update', $buku->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="KategoriID" class="form-label">Pilih Kategori</label>
                                    <div>
                                        @foreach ($kategoris as $kategori)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="KategoriID[]" value="{{ $kategori->id }}"
                                                    {{ $buku->kategoris->contains($kategori->id) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $kategori->NamaKategori }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add jQuery and DataTable JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('.bukuTable').DataTable();
    });
</script>

@endsection
