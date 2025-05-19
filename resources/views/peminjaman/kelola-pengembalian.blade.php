@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/peminjaman.css')}}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


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
        <table class="table table-bordered table-striped align-middle datatable">
            <thead class="table-dark">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Buku Dipinjam</th>
                    <th>Buku Dikembalikan</th>
                    <th>Status Keseluruhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->user->nis ?? '-' }}</td>
                        <td>{{ $peminjaman->user->nama ?? '-' }}</td>
<!-- Buku Dipinjam -->
<td>
    <ul class="mb-0">
        @forelse($peminjaman->bukus->whereNull('pivot.tanggal_kembali') as $buku)
            <li>{{ $buku->kode_buku }} - {{ $buku->NamaBuku }}</li>
        @empty
            <li><em>Tidak ada</em></li>
        @endforelse
    </ul>
</td>

<!-- Buku Dikembalikan -->
<td>
    <ul class="mb-0">
        @forelse($peminjaman->bukus->whereNotNull('pivot.tanggal_kembali') as $buku)
            <li>
                {{ $buku->kode_buku }} - {{ $buku->NamaBuku }}<br>
                <small class="text-muted">Kembali: {{ $buku->pivot->tanggal_kembali }}</small><br>
                <small class="text-danger">Denda: Rp{{ number_format($buku->pivot->denda, 0, ',', '.') }}</small>
            </li>
        @empty
            <li><em>Belum ada</em></li>
        @endforelse
    </ul>
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
                                            <div class="mb-3 tanggal-kembali-wrapper" style="display: none;">
                                            <label for="tanggal_kembali_{{ $peminjaman->id }}" class="form-label">Tanggal Kembali</label>
                                            <input type="date" name="tanggal_kembali" id="tanggal_kembali_{{ $peminjaman->id }}" class="form-control">
                                            </div>

                                        </div>
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
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
function hitungHariKerja(startDate, endDate) {
    let count = 0;
    const current = new Date(startDate);

    while (current <= endDate) {
        const day = current.getDay();
        // 0 = Minggu, 6 = Sabtu, kita skip
        if (day !== 0 && day !== 6) {
            count++;
        }
        current.setDate(current.getDate() + 1);
    }

    return count;
}

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

                // Fungsi untuk cek apakah ada checkbox yang dicentang
        function updateTanggalKembaliVisibility(modal) {
            const checkboxes = modal.querySelectorAll('.buku-checkbox');
            const tanggalWrapper = modal.querySelector('.tanggal-kembali-wrapper');

            const isChecked = Array.from(checkboxes).some(cb => cb.checked);
            tanggalWrapper.style.display = isChecked ? 'block' : 'none';
        }

        // Pasang event listener untuk setiap checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                updateTanggalKembaliVisibility(modal);
            });
        });

        // Inisialisasi awal saat modal dibuka (kalau user reload modal dengan pilihan sebelumnya)
        updateTanggalKembaliVisibility(modal);

        // Hitung denda saat tanggal kembali diubah
        tanggalInput.addEventListener('change', function () {
            const tanggalKembali = new Date(this.value);

            checkboxes.forEach(checkbox => {
                if (!checkbox.checked) return;

                const jatuhTempoStr = checkbox.dataset.jatuhTempo;
                const jatuhTempo = new Date(jatuhTempoStr);

                // Kalau tanggal kembali kurang dari atau sama dengan jatuh tempo, denda = 0
                if (tanggalKembali <= jatuhTempo) {
                    denda = 0;
                } else {
                    // Hitung hari kerja keterlambatan, mulai dari hari setelah jatuh tempo sampai tanggal kembali
                    // Misal jatuh tempo 10 Mei, tanggal kembali 13 Mei, hitung dari 11 Mei sampai 13 Mei
                    const startDate = new Date(jatuhTempo);
                    startDate.setDate(startDate.getDate() + 1);

                    const hariKerjaTerlambat = hitungHariKerja(startDate, tanggalKembali);
                    var denda = hariKerjaTerlambat * 1000;
                }

                const bukuId = checkbox.dataset.bukuId;
                const inputDenda = modal.querySelector(`#denda_${modal.id.split('-')[1]}_${bukuId}`);
                if (inputDenda) {
                    inputDenda.value = denda;
                }
            });
        });
    });
});

//DATA TABLE
$(document).ready(function() {
    $('.datatable').DataTable({
        searching: false
    });
});

</script>
@endsection
