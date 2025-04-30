<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PinjamBukuController extends Controller
{
    public function simpanPeminjaman(Request $request)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'nama_peminjam' => $request->nama_peminjam,
                'tanggal_pinjam' => now(),
            ]);

            foreach ($request->buku_id as $bukuId) {
                $jumlah = $request->input("jumlah_buku.$bukuId");
                $buku = Buku::findOrFail($bukuId);

                if ($buku->stok < $jumlah) {
                    throw new \Exception("Stok buku '{$buku->NamaBuku}' tidak mencukupi.");
                }

                $peminjaman->bukus()->attach($bukuId, ['jumlah' => $jumlah]);
                $buku->decrement('stok', $jumlah);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Peminjaman berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
