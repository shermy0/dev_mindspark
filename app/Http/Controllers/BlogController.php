<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Ulasan;
use App\Models\User;

class BlogController extends Controller
{
    // Method welcome dengan data statistik untuk halaman welcome
    public function welcome()
    {
        $bookCount = Buku::count();
        $categoriesCount = Kategori::count();
        $reviewCount = Ulasan::count();
        $userCount = User::count();

        return view('welcome', compact('bookCount', 'categoriesCount', 'reviewCount', 'userCount'));
    }

    // Method welcome tanpa data (bisa kamu hapus kalau sudah ada yang di atas)
    // public function welcome(){
    //     return view('welcome');
    // }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    // Setelah login
    public function home()
    {
        return view('home');
    }

    public function bookshelf()
    {
        return view('bookshelf');
    }

    public function favorite()
    {
        return view('favorite');
    }

    public function chatcs()
    {
        return view('chatcs');
    }

    public function account()
    {
        return view('account');
    }
}
