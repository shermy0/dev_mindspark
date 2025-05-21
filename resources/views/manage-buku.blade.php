@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/manage.css') }}">

<h3 class="mt-4">Kelola Buku</h3>
<a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Tambah Buku Baru</a>

<table class="table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->NamaBuku }}</td>
            <td>{{ $book->penulis }}</td>
            <td>{{ $book->penerbit }}</td>
            <td>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $book->id }})">Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda yakin mau menghapus buku <strong class="text-primary">{{ $book->NamaBuku }}</strong>
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

<!-- JavaScript -->
<script>
    function confirmDelete(bookId) {
        let form = document.getElementById('deleteForm');
        form.action = "{{ route('manage-buku.destroy', '') }}/" + bookId; 
        let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
@endsection
