<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\StatistikPengunjung;
use App\Models\Pengunjung;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Catat statistik pengunjung jika user adalah petugas
        if (Auth::check() && Auth::user()->role === 'petugas') {
            StatistikPengunjung::create([
                'ip_address' => Request::ip(),
                'user_agent' => Request::header('User-Agent'),
            ]);
        }

        // Composer view untuk mencatat jumlah pengunjung per hari
        View::composer('*', function () {
            if (!app()->runningInConsole()) {
                $today = Carbon::today();
                $pengunjung = Pengunjung::firstOrCreate(['tanggal' => $today]);
                $pengunjung->increment('jumlah');
            }
        });
    }
}
