<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    // Menampilkan dashboard berdasarkan role
    public function dashboard()
    {
        $role = Auth::user()->role;

        if ($role == 'administrator') {
            return view('admin.dashboard');
        } elseif ($role == 'petugas') {
            return view('petugas.dashboard');
        } else {
            return view('user.dashboard');
        }
    }

    // Menyimpan profil yang diperbarui oleh user
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Simpan foto baru jika diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto ke storage/public
            $fotoPath = $request->file('foto')->store('', 'public');
            $user->foto = $fotoPath;
        }

        // Update informasi profil
        $user->nama = $request->nama;
        $user->alamat = $request->alamat;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Menyimpan pengguna baru dari form modal (dari halaman kelola pengguna)
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required|string|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => bcrypt($request->password),
            'role' => 'user', // default role user biasa
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');
    }
}
