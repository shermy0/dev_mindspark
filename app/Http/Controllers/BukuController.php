<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Method untuk menampilkan detail buku
    public function show($id)
    {
        // Ambil data buku beserta relasinya (kategori dan ulasan)
        $buku = Buku::with(['kategoris', 'ulasans.user', 'views'])->findOrFail($id);

        // Hitung rata-rata rating dari ulasan buku
        $averageRating = $buku->ulasans->avg('Rating') ?? 0;

        // Ambil buku lain kecuali buku yang sedang ditampilkan
        $otherBooks = Buku::where('id', '!=', $id)->get();

        // Cek apakah buku sudah dipinjam oleh user (status = borrowed)
        $isBorrowed = false;
        if (auth()->check()) {
            $isBorrowed = Peminjaman::where('UserID', auth()->user()->id)
                ->where('BukuID', $buku->id)
                ->where('StatusPeminjaman', 'borrowed')
                ->exists();
        }

        // Hitung total views buku (jumlah record di relasi views)
        $totalViews = $buku->views->count();

        // Kirim data ke view 'buku.detail' (atau sesuai nama view detail buku kamu)
        return view('buku', compact('buku', 'averageRating', 'otherBooks', 'isBorrowed', 'totalViews'));
    }

    // Method untuk baca buku, berada di folder view buku, file baca.blade.php
    public function baca($id)
    {
        $buku = Buku::findOrFail($id);

        // Pisah isi buku berdasarkan tag [[BAB]]
        $babList = preg_split('/\[\[BAB\]\]/', $buku->isibuku, -1, PREG_SPLIT_NO_EMPTY);

        return view('buku.baca', compact('buku', 'babList'));
    }
}
