@extends('master')

@section('konten')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Header + Dropdown Pilih Bab (judul fix center) --}}
            <div class="position-relative mb-4">

                {{-- Tombol Kembali --}}
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary shadow-sm position-absolute start-0 top-50 translate-middle-y">
                    ←
                </a>

                {{-- Judul Buku (tetap di tengah) --}}
                <h2 class="text-dark text-center m-0">
                    {{ $buku->NamaBuku }}
                </h2>

                {{-- Dropdown Pilih Bab --}}
                <div class="position-absolute end-0 top-50 translate-middle-y" style="min-width: 160px;">
                    <select id="pilihBab" class="form-select">
                        @foreach($babList as $index => $bab)
                            <option value="bab-{{ $index }}">Bab {{ $index + 1 }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Konten Bab --}}
            @foreach($babList as $index => $bab)
                <div id="bab-{{ $index }}" class="card shadow-sm rounded-4 bab-content" style="{{ $index != 0 ? 'display:none;' : '' }}">
                    <div class="card-body p-4">
                        <p class="text-dark text-justify" style="line-height: 1.8; font-size: 1.1rem;">
                            {!! nl2br(e(trim($bab))) !!}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

{{-- Script untuk pilih bab --}}
<script>
    document.getElementById('pilihBab').addEventListener('change', function () {
        let selected = this.value;
        document.querySelectorAll('.bab-content').forEach(el => el.style.display = 'none');
        document.getElementById(selected).style.display = 'block';
    });
</script>
@endsection
