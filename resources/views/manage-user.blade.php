@extends('master')
<<<<<<< HEAD
@section('konten')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/manage.css') }}">
<div class="container-fluid">
    <div class="row">
        <!-- Main content -->
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Kelola Pengguna</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete('{{ route('manage-user.destroy', $user->id) }}', '{{ $user->nama }}')">
                                Hapus
                            </button>
                            

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

=======

@section('konten')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/manage.css') }}">

<h2 class="mt-4 mb-3">Kelola Pengguna</h2>

@if(session('success'))
    <strong><div class="alert alert-success">{{ session('success') }}</div></strong>
@endif

<button type="button" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#registerModal">
  Tambah Pengguna
</button>

<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Form Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <div class="container">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="nis" class="form-label">NIS/NIP</label>
              <input type="text" class="form-control" name="nis" required>
            </div>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <input type="text" class="form-control" name="alamat" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Kata Sandi</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
              <input type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn text-dark buttonmasuk w-100">Daftar</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>


<table class="table table-striped">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="confirmDelete('{{ route('manage-user.destroy', $user->id) }}', '{{ $user->nama }}')">
                    Hapus
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

>>>>>>> preview
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
<<<<<<< HEAD
                <p>Apakah Anda yakin ingin menghapus <strong id="deleteUserName"></strong>?</p>
=======
                <p>Apakah Anda yakin ingin menghapus <strong class="text-primary" id="deleteUserName"></strong></p>
>>>>>>> preview
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
<<<<<<< HEAD
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal')); // Inisialisasi modal di luar function
=======
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
>>>>>>> preview

    function confirmDelete(url, name) {
        document.getElementById('deleteUserName').textContent = name;
        document.getElementById('deleteForm').action = url;
<<<<<<< HEAD
        deleteModal.show(); // Panggil modal tanpa inisialisasi ulang
    }
</script>


@endsection 
=======
        deleteModal.show();
    }
</script>
@endsection
>>>>>>> preview
