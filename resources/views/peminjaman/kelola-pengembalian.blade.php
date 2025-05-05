@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/peminjaman.css')}}">

<div class="container mt-4">
    <h3 class="mb-4">Kelola Pengembalian</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('kelola-pengembalian') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="nama" class="form-control" placeholder="Cari Nama Siswa" value="{{ request('nama') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="buku" class="form-control" placeholder="Cari Kode atau Judul Buku" value="{{ request('buku') }}">
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kode & Judul Buku</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->user->nis ?? '-' }}</td>
                        <td>{{ $peminjaman->user->nama ?? '-' }}</td>
                        <td>
                            <ul class="mb-0">
                                @foreach($peminjaman->bukus as $buku)
                                    <li><strong>{{ $buku->kode_buku }}</strong> - {{ $buku->NamaBuku }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <span class="badge bg-{{ $peminjaman->status_peminjaman == 'dipinjam' ? 'warning' : 'success' }}">
                                {{ ucfirst($peminjaman->status_peminjaman) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.form-pengembalian', $peminjaman->id) }}" class="btn btn-sm btn-primary mt-2">
                                Ganti Status
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data peminjaman</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
