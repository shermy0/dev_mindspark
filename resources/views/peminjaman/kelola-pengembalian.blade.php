@extends('master')
@section('konten')

<div class="container">
    <h1 class="mb-4">Daftar Peminjaman</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->user->nis }}</td>
                    <td>{{ $peminjaman->user->nama }}</td>
                    <td>{{ $peminjaman->buku->kode_buku }}</td>
                    <td>{{ $peminjaman->buku->NamaBuku }}</td>
                    <td>
                        @if($peminjaman->StatusPeminjaman == 'dipinjam')
                            <a href="{{ route('peminjaman.formPengembalian', $peminjaman->id) }}" class="btn btn-primary btn-sm">Kembalikan</a>
                        @else
                            <span class="badge bg-success">Sudah Dikembalikan</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
