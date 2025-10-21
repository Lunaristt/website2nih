<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan Nama
        $user = Pengguna::where('Nama', $request->nama)->first();

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($request->password, $user->Password)) {
            // Simpan data ke session
            session([
                'user_id' => $user->ID_Pengguna,
                'nama' => $user->Nama,
                'role' => $user->Role,
            ]);

            // Redirect sesuai role
            if ($user->Role === 'admin') {
                return redirect()->route('dashboard')->with('success', 'Selamat datang Admin!');
            } else {
                return redirect()->route('home')->with('success', 'Selamat datang, ' . $user->Nama . '!');
            }
        }

        // Kalau gagal login
        return redirect()->route('login')->with('error', 'Username atau Password salah!');
    }

    /**
     * Logout dan hapus session.
     */
    public function logout(Request $request)
    {
        // Hapus semua session
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
