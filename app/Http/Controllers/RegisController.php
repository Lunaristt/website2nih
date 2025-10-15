<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use App\Models\User; // pastikan model User sudah ada
use Illuminate\Support\Facades\Hash;

class RegisController extends Controller
{
    // Form registrasi
    public function create()
    {
        return view('regis'); // file blade form register
    }

    // Simpan data registrasi
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Nama' => 'required|string|max:50',
            'Password' => 'required|string|min:6',
            'No_Telp' => 'required|string|max:15',
        ]);

        // Simpan ke database
        Pengguna::create([
            'Nama' => $request->Nama,
            'Password' => Hash::make($request->Password), // hash password
            'No_Telp' => $request->No_Telp,
        ]);

        // Redirect ke login atau home
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
