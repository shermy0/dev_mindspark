<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Statistik;
use App\Models\StatistikPengunjung;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user adalah petugas
        $user = Auth::user();

        if ($user->role !== 'petugas') {
            abort(403, 'Akses ditolak');
        }

        // Hitung statistik
        $totalUser = User::where('role', 'user')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();

        // Total pengunjung
        $totalPengunjung = StatistikPengunjung::count();

        return view('dashboard', compact(
            'totalUser',
            'totalPetugas',
            'totalBuku',
            'totalKategori',
            'totalPengunjung'
        ));
    }
}
