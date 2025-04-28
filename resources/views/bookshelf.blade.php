@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/bookshelf.css') }}">

<div class="container mt-4">
    <h1>Rak Bukumu</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Buku yang Dipinjam --}}
    <div class="section borrowed-section">
        <h2 class="text-center">Buku yang Dipinjam</h2>
        <div class="row justify-content-center">
            @forelse($borrowedBooks as $pinjam)
                <div class="col-md-5 mb-4">
                    <div class="card h-100">
                        @if($pinjam->buku->CoverBuku)
                            <img src="{{ asset('storage/cover_buku/' . $pinjam->buku->CoverBuku) }}" class="card-img-top" alt="{{ $pinjam->buku->NamaBuku }}">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height:250px; background-color: #f0f0f0;">
                                Gambar Tidak Tersedia
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $pinjam->buku->NamaBuku }}</h5>
                                <p class="card-text">{{ $pinjam->buku->Penulis ?? 'Penulis tidak tersedia' }}</p>
                            </div>

                            <div class="info mt-3">
                                <p>Dipinjam Pada: <strong>{{ \Carbon\Carbon::parse($pinjam->TanggalPeminjaman)->format('Y-m-d') }}</strong></p>
                                <p>Jatuh Tempo: <strong>{{ \Carbon\Carbon::parse($pinjam->TanggalPeminjaman)->addDays(7)->format('Y-m-d') }}</strong></p>
                                
                                @php
                                    $jatuhTempo = \Carbon\Carbon::parse($pinjam->TanggalPeminjaman)->addDays(7);
                                    $hariKeterlambatan = now()->diffInDays($jatuhTempo, false);
                                @endphp

                                @if($hariKeterlambatan < 0)
                                    <p class="text-danger">Terlambat {{ abs($hariKeterlambatan) }} hari</p>
                                @else
                                    <p class="text-success">Sisa {{ $hariKeterlambatan }} hari lagi</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Belum ada buku yang dipinjam.</p>
            @endforelse
        </div>
    </div>

    {{-- Buku yang Dikembalikan --}}
    <div class="section returned-section">
        <h2 class="text-center">Buku yang Dikembalikan</h2>
        <div class="row justify-content-center">
            @forelse($returnedBooks as $pinjam)
                <div class="col-md-5 mb-4">
                    <div class="card h-100">
                        @if($pinjam->buku->CoverBuku)
                            <img src="{{ asset('storage/cover_buku/' . $pinjam->buku->CoverBuku) }}" class="card-img-top" alt="{{ $pinjam->buku->NamaBuku }}">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height:250px; background-color: #f0f0f0;">
                                Gambar Tidak Tersedia
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $pinjam->buku->NamaBuku }}</h5>
                                <p class="card-text">{{ $pinjam->buku->Penulis ?? 'Penulis tidak tersedia' }}</p>
                            </div>

                            <div class="info mt-3">
                                <p>Dipinjam Pada: <strong>{{ \Carbon\Carbon::parse($pinjam->TanggalPeminjaman)->format('Y-m-d') }}</strong></p>
                                <p>Dikembalikan Pada: <strong>{{ \Carbon\Carbon::parse($pinjam->TanggalPengembalian)->format('Y-m-d') }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">Belum ada buku yang dikembalikan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
