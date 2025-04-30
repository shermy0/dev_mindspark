@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('css/bookshelf.css') }}">

<div class="container mt-4 tab-wrapper body-borrowed" id="tab-wrapper">
    <h1>Rak Bukumu</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="tab-container">
        <button onclick="showTab('borrowed')" class="tab-btn active borrowed" id="btn-borrowed">Dipinjam</button>
        <button onclick="showTab('returned')" class="tab-btn returned" id="btn-returned">Dikembalikan</button>
    </div>

    <div id="tab-borrowed" class="tab-content active">
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
                                        $dendaPerHari = 1000;
                                        $totalDenda = abs($hariKeterlambatan) * $dendaPerHari;
                                    @endphp
                                    @if($hariKeterlambatan < 0)
                                    <p class="text-danger">Terlambat {{ abs($hariKeterlambatan) }} hari</p>
                                    <p class="text-danger">
                                        Denda: <strong>Rp{{ number_format($totalDenda, 0, ',', '.') }}</strong>
                                        <button class="btn btn-sm btn-danger info-btn" onclick="showPopup('{{ abs($hariKeterlambatan) }}', '{{ number_format($totalDenda, 0, ',', '.') }}')">!</button>
                                    </p>
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
    </div>

    <div id="tab-returned" class="tab-content">
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
    <div id="popupDenda" class="popup-denda" style="display:none;">
        <div class="popup-content">
            <h4><strong>Informasi Denda</strong></h4>
            <p id="popupText">...</p>
            <button class="btn mt-3" onclick="closePopup()" style="background-color: #81d4fa; color: black;">Kembali</button>
        </div>
    </div>    
</div>

<script>
    function showTab(tab) {
        const wrapper = document.getElementById('tab-wrapper');
        const tabBorrowed = document.getElementById('tab-borrowed');
        const tabReturned = document.getElementById('tab-returned');
        const btnBorrowed = document.getElementById('btn-borrowed');
        const btnReturned = document.getElementById('btn-returned');

        tabBorrowed.classList.remove('active');
        tabReturned.classList.remove('active');

        if (tab === 'borrowed') {
            tabBorrowed.classList.add('active');
        } else {
            tabReturned.classList.add('active');
        }

        btnBorrowed.classList.remove('active', 'borrowed');
        btnReturned.classList.remove('active', 'returned');

        if (tab === 'borrowed') {
            btnBorrowed.classList.add('active', 'borrowed');
        } else {
            btnReturned.classList.add('active', 'returned');
        }

        wrapper.classList.remove('body-borrowed', 'body-returned');
        wrapper.classList.add(tab === 'borrowed' ? 'body-borrowed' : 'body-returned');
    }
    function showPopup(hari, denda) {
    document.getElementById('popupText').innerText = `Kamu terlambat mengembalikan buku selama ${hari} hari dan harus membayar denda sebesar Rp${denda}, mohon segera kembalikan buku jika ingin diperpanjang agar bisa dipinjam kembali.`;
    document.getElementById('popupDenda').style.display = 'flex';
    }
    function closePopup() {
        document.getElementById('popupDenda').style.display = 'none';
    }
</script>
@endsection