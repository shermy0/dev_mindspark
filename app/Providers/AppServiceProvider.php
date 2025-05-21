<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\StatistikPengunjung;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check() && Auth::user()->role === 'petugas') {
            StatistikPengunjung::create([
                'ip_address' => Request::ip(),
                'user_agent' => Request::header('User-Agent'),
            ]);
        }
    }
}
