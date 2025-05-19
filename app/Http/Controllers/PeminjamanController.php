<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
// In your PeminjamanController
public function simpanPeminjaman(Request $request)
{
    // Validation
    $request->validate([
        'tanggal_pinjam' => 'required|date',
        'tanggal_jatuh_tempo' => 'required|date',
        'buku_id' => 'required|array', // Ensure buku_id is an array
        'buku_id.*' => 'exists:bukus,id', // Validate that each buku_id exists in the buku table
    ]);

    // Create a new peminjaman record
    $peminjaman = Peminjaman::create([
        'user_id' => $request->UserID,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
    ]);

    // Attach buku to the peminjaman (assuming many-to-many relationship)
    $peminjaman->bukus()->sync($request->buku_id);

    
    return redirect()->route('kelola-pengembalian')->with('success', 'Peminjaman berhasil!');
}

public function kelolaPengembalian(Request $request)
{
    $query = Peminjaman::with(['user', 'bukus']);

    // Filter status
    if ($request->status) {
        $query->where('status_peminjaman', $request->status);
    }

    // Search berdasarkan nama
    if ($request->nama) {
        $query->whereHas('user', function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->nama . '%');
        });
    }

    // Search berdasarkan kode atau judul buku
    if ($request->buku) {
        $query->whereHas('bukus', function($q) use ($request) {
            $q->where('kode_buku', 'like', '%' . $request->buku . '%')
              ->orWhere('NamaBuku', 'like', '%' . $request->buku . '%');
        });
    }

    // Sort berdasarkan tanggal terbaru/terlama
    if ($request->sort == 'terlama') {
        $query->orderBy('tanggal_pinjam', 'asc');
    } else {
        $query->orderBy('tanggal_pinjam', 'desc'); // default terbaru
    }

    $peminjamans = $query->get();

    return view('peminjaman.kelola-pengembalian', compact('peminjamans'));
}

public function formPengembalian($id)
{
    $peminjaman = Peminjaman::with('bukus', 'user')->findOrFail($id);
    return view('peminjaman.form-pengembalian', compact('peminjaman'));
}


}