<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;
use Illuminate\Support\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        return view('dashboard.statistik', [
            'hariIni' => Pengunjung::where('tanggal', $today)->sum('jumlah'),
            'kemarin' => Pengunjung::where('tanggal', $today->copy()->subDay())->sum('jumlah'),
            'mingguIni' => Pengunjung::whereBetween('tanggal', [$startOfWeek, $today])->sum('jumlah'),
            'bulanIni' => Pengunjung::whereBetween('tanggal', [$startOfMonth, $today])->sum('jumlah'),
            'tahunIni' => Pengunjung::whereBetween('tanggal', [$startOfYear, $today])->sum('jumlah'),
            'total' => Pengunjung::sum('jumlah'),
        ]);
    }
}
