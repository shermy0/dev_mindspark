<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon; // kalau mau pakai tanggal sekarang


class PeminjamanController extends Controller
{
    // Ini buat halaman daftar-pinjam.blade.php
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->where('StatusPeminjaman', 'Dipinjam') // ambil yang status masih dipinjam
            ->get();

        return view('peminjaman.kelola-pengembalian', compact('peminjamans'));
    }

    // Ini buat halaman form-pengembalian.blade.php
    public function formPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        return view('peminjaman.form-pengembalian', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'UserID' => 'required|exists:users,id',
            'BukuID' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);
    
        Peminjaman::create([
            'UserID' => $request->UserID,
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => $request->tanggal_pinjam,
            'TanggalPengembalian' => $request->tanggal_jatuh_tempo,
            'StatusPeminjaman' => 'Dipinjam',
        ]);
    
        return redirect()->route('kelola-pengembalian')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function simpanPeminjaman(Request $request)
{
    $validated = $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_jatuh_tempo' => 'required|date',
        'BukuID' => 'required|array',
        'BukuID.*' => 'integer|exists:bukus,id', // ← perbaiki di sini
        'UserID' => 'required|exists:users,id',
    ]);
    

    // Simpan data peminjaman
    $peminjaman = new Peminjaman();
    $peminjaman->user_id = $request->UserID;
    $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
    $peminjaman->tanggal_jatuh_tempo = $request->tanggal_jatuh_tempo;
    $peminjaman->save();

    // Simpan relasi peminjaman dengan buku
    foreach ($request->buku_id as $buku_id) {
        PeminjamanBuku::create([
            'peminjaman_id' => $peminjaman->id,
            'buku_id' => $buku_id,
        ]);
    }

    // Redirect atau return response sukses
    return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dilakukan!');
}


}
