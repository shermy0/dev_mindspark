@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('css/manage.css') }}">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<div class="container-fluid">
    <div class="row">
        <!-- Main content -->
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Kelola Buku</h3>
                    <a href="{{ route('books.create') }}" class="btn btn-primary float-end">Tambah Buku Baru</a>
                </div>
                <div class="card-body">
                    <!-- Hanya satu table dengan class datatable -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Stok Awal</th>
                                <th>Ketersediaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>{{ $book->NamaBuku }}</td>
                                <td>{{ $book->penulis }}</td>
                                <td>{{ $book->penerbit }}</td>
                                <td>{{ $book->stok }}</td>
                                <td>
                                    <form action="{{ route('books.updateKetersediaan', $book->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="ketersediaan" onchange="this.form.submit()" class="form-select form-select-sm">
                                            <option value="Tersedia" {{ $book->ketersediaan == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="Tidak Tersedia" {{ $book->ketersediaan == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $book->id }})">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda yakin mau menghapus buku ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<!-- Inisialisasi DataTable -->
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });

    function confirmDelete(id) {
        const url = "{{ url('books') }}/" + id;
        $('#deleteForm').attr('action', url);
        $('#deleteModal').modal('show');
    }
</script>
@endsection
