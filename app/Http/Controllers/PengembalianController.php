<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function store(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'buku_ids' => 'required|array'
        ]);

        foreach ($request->buku_ids as $bukuId) {
            $jatuhTempo = $peminjaman->tanggal_jatuh_tempo;
            $tanggalKembali = Carbon::parse($request->tanggal_kembali);
            $selisih = $tanggalKembali->greaterThan($jatuhTempo)
                ? $tanggalKembali->diffInDays($jatuhTempo)
                : 0;

            $denda = $selisih * 1000;

            $peminjaman->bukus()->updateExistingPivot($bukuId, [
                'tanggal_kembali' => $tanggalKembali,
                'denda' => $denda,
            ]);
        }

        return redirect()->back()->with('success', 'Pengembalian berhasil diproses.');
    }
}
