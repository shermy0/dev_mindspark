@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/peminjaman.css')}}">

<div class="container">
    <h1 class="judul-peminjaman mb-4">Kelola Peminjaman</h1>

    <!-- Search Form -->
    <form action="{{ route('kelola-peminjaman') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari NIS atau Nama..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-header">
                <tr>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <img src="{{ $user->foto_url }}" alt="User Avatar" class="user-avatar">
                        </td>
                        <td>{{ $user->nis }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>
                            <a href="{{ route('form-peminjaman', $user->id) }}" class="btn btn-success btn-pinjam">
                                <i class="bi bi-box-arrow-in-down"></i> Pinjam
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center data-kosong">
                            <i class="bi bi-emoji-frown kosong-icon"></i>
                            <div class="kosong-text">Nama atau NIS tidak ditemukan.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
