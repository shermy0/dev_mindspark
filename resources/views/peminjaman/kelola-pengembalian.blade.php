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
                                  <li>
                                    {{ $buku->kode_buku }} - {{ $buku->NamaBuku }}
                                    <br>
                                    <small class="text-muted">Kembali: {{ $buku->pivot->tanggal_kembali }}</small>
                                    <br>
                                    <small class="text-danger">Denda: Rp{{ number_format($buku->pivot->denda, 0, ',', '.') }}</small>
                                  </li>
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
                          {{ $totalBuku == $bukuKembali ? 'dikembalikan' : 'dipinjam' }}
                      </span>
                      
                        </td>
                      
                        <td>
                          <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalPengembalian-{{ $peminjaman->id }}">
                              Ganti Status
                          </button>
                          @foreach ($peminjamans as $peminjaman)
                          <!-- Modal -->
                          <div class="modal fade" id="modalPengembalian-{{ $peminjaman->id }}" tabindex="-1" aria-hidden="true"
                              data-jatuh-tempo="{{ $peminjaman->tanggal_jatuh_tempo }}">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <form action="{{ route('pengembalian.store', $peminjaman->id) }}" method="POST">
                                          @csrf
                                          @method('POST')
                                          <div class="modal-header">
                                              <h5 class="modal-title">Pengembalian Buku</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            {{-- Informasi Anggota --}}
                                            <div class="mb-3">
                                                <label class="form-label">NIS</label>
                                                <input type="text" class="form-control" value="{{ $peminjaman->user->nis }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control" value="{{ $peminjaman->user->nama }}" readonly>
                                            </div>
                                        
                                        <div>
                                          <label class="form-label">Pilih Buku yang Dikembalikan</label>
                                        </div>
                                            {{-- Daftar Buku --}}
                                            @foreach ($peminjaman->bukus as $buku)
                                            @if (!$buku->pivot->tanggal_kembali)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input buku-checkbox" 
                                                       type="checkbox" 
                                                       name="buku_ids[]" 
                                                       value="{{ $buku->id }}" 
                                                       id="buku{{ $peminjaman->id }}_{{ $buku->id }}" 
                                                       data-buku-id="{{ $buku->id }}"
                                                       data-jatuh-tempo="{{ $peminjaman->tanggal_jatuh_tempo }}">
                                                <label class="form-check-label" for="buku{{ $peminjaman->id }}_{{ $buku->id }}">
                                                    {{ $buku->kode_buku }} - {{ $buku->NamaBuku }}
                                                </label>
                                        
                                                <div class="mt-1 denda-wrapper" style="display: none;">
                                                    <label for="denda_{{ $peminjaman->id }}_{{ $buku->id }}" class="form-label small">Denda (Rp)</label>
                                                    <input type="number" 
                                                           name="denda[{{ $buku->id }}]" 
                                                           id="denda_{{ $peminjaman->id }}_{{ $buku->id }}" 
                                                           class="form-control form-control-sm denda-input" 
                                                           value="0" 
                                                           >
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach

                                        {{-- Input Tanggal Kembali --}}
                                        <div class="mb-3">
                                          <label for="tanggal_kembali_{{ $peminjaman->id }}" class="form-label">Tanggal Kembali</label>
                                          <input type="date" name="tanggal_kembali" id="tanggal_kembali_{{ $peminjaman->id }}" class="form-control" required>
                                      </div>
                                        </div>

                                        
                                          {{-- <div class="modal-body">

                          
                                              @foreach ($peminjaman->bukus as $buku)
                                                  <input type="hidden" name="buku_ids[]" value="{{ $buku->id }}">
                                                  <div class="mb-3">
                                                      <label class="form-label">{{ $buku->judul }} - Denda (Rp)</label>
                                                      <input type="number" name="denda[]" id="denda_{{ $peminjaman->id }}_{{ $buku->id }}" class="form-control" value="0" readonly>
                                                  </div>
                                              @endforeach
                                          </div> --}}
                                          <div class="modal-footer">
                                              <button type="submit" class="btn btn-primary">Simpan</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                          @endforeach
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modals = document.querySelectorAll('[id^="modalPengembalian-"]');

    modals.forEach(modal => {
        const tanggalInput = modal.querySelector('input[name="tanggal_kembali"]');

        if (!tanggalInput) return;

        const checkboxes = modal.querySelectorAll('.buku-checkbox');

        // Tampilkan/hide input denda saat checkbox dipilih
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const wrapper = this.closest('.form-check').querySelector('.denda-wrapper');
                if (this.checked) {
                    wrapper.style.display = 'block';
                } else {
                    wrapper.style.display = 'none';
                }
            });
        });

        // Hitung denda saat tanggal kembali diubah
        tanggalInput.addEventListener('change', function () {
            const tanggalKembali = new Date(this.value);

            checkboxes.forEach(checkbox => {
                if (!checkbox.checked) return;

                const jatuhTempoStr = checkbox.dataset.jatuhTempo;
                const jatuhTempo = new Date(jatuhTempoStr);
                const selisihHari = Math.floor((tanggalKembali - jatuhTempo) / (1000 * 60 * 60 * 24));
                const denda = selisihHari > 0 ? selisihHari * 1000 : 0;

                const bukuId = checkbox.dataset.bukuId;
                const inputDenda = modal.querySelector(`#denda_${modal.id.split('-')[1]}_${bukuId}`);
                if (inputDenda) {
                    inputDenda.value = denda;
                }
            });
        });
    });
});
</script>
@endsection
