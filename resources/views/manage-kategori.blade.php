@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/kategoribuku.css') }}">

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
    <button type="submit" class="btn custom-btn">Tambah Kategori</button>
</form>

<table class="table table-striped mt-4">
    <thead>
        <tr>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kategoris as $kategori)
        <tr>
            <td>{{ $kategori->NamaKategori }}</td>
            <td>
                <!-- Tombol hapus trigger modal konfirmasi -->
                <button type="button" 
                    class="btn btn-danger btn-sm" 
                    onclick="confirmDelete('{{ route('kategori.destroy', $kategori->id) }}', '{{ $kategori->NamaKategori }}')">
                    Hapus
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus kategori <strong class="text-primary" id="deleteKategoriName"></strong>
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

<script>
  // Membuat objek modal Bootstrap
  var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

  // Fungsi dipanggil saat tombol hapus ditekan
  function confirmDelete(url, kategoriName) {
    // Tampilkan nama kategori di modal
    document.getElementById('deleteKategoriName').textContent = kategoriName;
    
    // Set action form hapus ke route yang sesuai
    var form = document.getElementById('deleteForm');
    form.action = url;
    
    // Tampilkan modal konfirmasi
    deleteModal.show();
  }
</script>
@endsection
