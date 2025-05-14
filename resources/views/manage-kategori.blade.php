@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/kategoribuku.css') }}">
<!-- Add the DataTable CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<div class="container">
    <h2 class="mb-4">Manage Kategori</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="NamaKategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="NamaKategori" name="NamaKategori" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
    </form>

    <!-- Add a class to your table -->
    <table class="table table-striped mt-4" id="kategoriTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $kategori)
            <tr>
                <td>{{ $kategori->id }}</td>
                <td>{{ $kategori->NamaKategori }}</td>
                <td>
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add jQuery and DataTable JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
    // Initialize the DataTable
    $(document).ready(function() {
        $('#kategoriTable').DataTable();
    });
</script>
@endsection
