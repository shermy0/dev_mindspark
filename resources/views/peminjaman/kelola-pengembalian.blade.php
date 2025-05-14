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
                    <th>Status Keseluruhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->user->nis ?? '-' }}</td>
                        <td>{{ $peminjaman->user->nama ?? '-' }}</td>
                        <td>
                          <div class="mb-2 borrow-field">
                              <strong>Buku Dipinjam:</strong>
                              <ul class="mb-1">
                                  @forelse($peminjaman->bukus->whereNull('pivot.tanggal_kembali') as $buku)
                                      <li>{{ $buku->kode_buku }} - {{ $buku->NamaBuku }}</li>
                                  @empty
                                      <li><em>Tidak ada</em></li>
                                  @endforelse
                              </ul>
                          </div>
                      
                          <div class="return-field">
                              <strong>Buku Dikembalikan:</strong>
                              <ul class="mb-0">
                                  @forelse($peminjaman->bukus->whereNotNull('pivot.tanggal_kembali') as $buku)
                                      <li>{{ $buku->kode_buku }} - {{ $buku->NamaBuku }} <br><small class="text-muted">Kembali: {{ $buku->pivot->tanggal_kembali }}</small></li>
                                  @empty
                                      <li><em>Belum ada</em></li>
                                  @endforelse
                              </ul>
                          </div>
                      </td>
                      
                        <td>
                          @php
                          $totalBuku = $peminjaman->bukus->count();
                          $bukuKembali = $peminjaman->bukus->whereNotNull('pivot.tanggal_kembali')->count();
                      @endphp
                      
                      <span class="badge bg-{{ $totalBuku == $bukuKembali ? 'success' : 'warning' }}">
                          {{ $totalBuku == $bukuKembali ? 'Dikembalikan' : 'Dipinjam' }}
                      </span>
                      
                        </td>
                        <td>
                          <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalPengembalian-{{ $peminjaman->id }}">
                              Ganti Status
                          </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalPengembalian-{{ $peminjaman->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <form method="POST" action="{{ route('pengembalian.store', $peminjaman->id) }}">
                                @csrf
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Form Pengembalian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                  </div>
                                  <div class="modal-body">
                                    <p><strong>NIS:</strong> {{ $peminjaman->user->nis }}</p>
                                    <p><strong>Nama:</strong> {{ $peminjaman->user->nama }}</p>
                          
                                    <div class="mb-3">
                                      <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                      <input type="date" name="tanggal_kembali" class="form-control" required>
                                    </div>
                          
                                    <div class="mb-3">
                                      <label class="form-label">Pilih Buku yang Dikembalikan</label>
                                      @foreach($peminjaman->bukus as $buku)
                                        @if (!$buku->pivot->tanggal_kembali) {{-- hanya tampilkan yang belum dikembalikan --}}
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="buku_ids[]" value="{{ $buku->id }}" id="buku{{ $buku->id }}">
                                            <label class="form-check-label" for="buku{{ $buku->id }}">
                                              {{ $buku->kode_buku }} - {{ $buku->NamaBuku }}
                                            </label>
                                          </div>
                                        @endif
                                      @endforeach
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>

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
