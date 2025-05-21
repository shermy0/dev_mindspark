@extends('master')

@section('konten')
<div class="container mt-4">
    <h2>Statistik Pengunjung</h2>
    <ul class="list-group">
        <li class="list-group-item">Hari Ini: {{ $hariIni }}</li>
        <li class="list-group-item">Kemarin: {{ $kemarin }}</li>
        <li class="list-group-item">Minggu Ini: {{ $mingguIni }}</li>
        <li class="list-group-item">Bulan Ini: {{ $bulanIni }}</li>
        <li class="list-group-item">Tahun Ini: {{ $tahunIni }}</li>
        <li class="list-group-item">Total Keseluruhan: {{ $total }}</li>
    </ul>
</div>
@endsection
