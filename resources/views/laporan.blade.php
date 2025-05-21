@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/laporan.css') }}">

<h2 class="mt-4 mb-3">Daftar Laporan</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($laporans->isEmpty())
    <div class="alert alert-info">Belum ada laporan yang masuk.</div>
@else
<div class="table-responsive">
  <table class="table">
      <thead class="text-center">
          <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Subjek</th>
              <th>Pesan</th>
              <th>Aksi</th>
          </tr>
      </thead>
      <tbody>
          @foreach($laporans as $laporan)
          <tr>
              <td>{{ $laporan->nama }}</td>
              <td>{{ $laporan->email }}</td>
              <td>{{ $laporan->subjek }}</td>
              <td>{{ $laporan->pesan }}</td>
              <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="confirmDelete('{{ route('laporan.destroy', $laporan->id) }}', '{{ $laporan->nama }}')">
                    Hapus
                </button>
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>
</div>
@endif

<!-- Modal Konfirmasi Hapus (letakkan di luar loop!) -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-dark">Apakah Anda yakin ingin menghapus <strong class="text-primary" id="deleteUserName"></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk handle tombol hapus dan modal -->
<script>
function confirmDelete(actionUrl, userName) {
    // Set action URL di form delete
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = actionUrl;

    // Set nama user di modal
    document.getElementById('deleteUserName').textContent = userName;

    // Tampilkan modal menggunakan Bootstrap 5 JS API
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>

@endsection
