<?php

use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RegisController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('regis')->group(function () {
    Route::get('/', [RegisController::class, 'create'])->name('register');
    Route::post('/', [RegisController::class, 'store'])->name('register.store');
});

Route::prefix('barang')->name('barang.')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('index');
    Route::post('/', [BarangController::class, 'store'])->name('store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('update');
    Route::post('/barang/{id}/tambah-stok', [BarangController::class, 'tambahStok'])->name('tambahStok');
    Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
    Route::post('/kategori/store', [BarangController::class, 'kategori'])->name('tambahkategori');
    Route::post('/satuan/store', [BarangController::class, 'satuan'])->name('tambahsatuani');
});

Route::get('/tambahkategori', function () {
    return view('tambahkategori'); // blade form kamu
})->name('tambahkategori');

Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/', [PelangganController::class, 'index'])->name('index');
    Route::get('/create', [PelangganController::class, 'create'])->name('create');
    Route::post('/store', [PelangganController::class, 'store'])->name('store');
    Route::get('/get-no-telp', [PelangganController::class, 'getNoTelp'])->name('getNoTelp');
});

Route::prefix('statustransaksi')->name('statustransaksi.')->group(function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('index');
    Route::get('/create', [PenjualanController::class, 'create'])->name('create');
    Route::post('/store', [PenjualanController::class, 'store'])->name('store');
    Route::get('/get-no-telp', [PenjualanController::class, 'getNoTelp'])->name('getNoTelp');
    Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('.destroy');
});

Route::get('/tambahpelanggan', function () {
    return view('tambahpelanggan'); // blade form kamu
})->name('tambahpelanggan');

Route::get('/tambahsatuan', function () {
    return view('tambahsatuan');
})->name('tambahsatuan');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::prefix('tambahbarang')->name('tambahbarang.')->group(function () {
    Route::get('/', [BarangController::class, 'create'])->name('create');
    Route::post('/', [BarangController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BarangController::class, 'update'])->name('update');
    Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
});

Route::prefix('transaksi')->name('transaksi.')->group(function () {
    //Tampilkan daftar transaksi (riwayat)
    Route::get('/', [TransaksiController::class, 'index'])->name('index');

    //Buat transaksi baru (halaman kasir)
    Route::get('/', [TransaksiController::class, 'create'])->name('create');

    //Tambah barang ke transaksi
    Route::post('/items', [TransaksiController::class, 'addItem'])->name('addItem');

    //Checkout transaksi & kurangi stok barang
    Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');

    //Batalkan transaksi & kembalikan stok
    Route::post('/cancel', [TransaksiController::class, 'cancel'])->name('cancel');

    //Hapus item tertentu dalam transaksi
    Route::delete('/{id}', [TransaksiController::class, 'destroy'])->name('destroy');

    //route baru untuk tombol "Batal"
    Route::post('/{id}/batal', [TransaksiController::class, 'batalTransaksi'])->name('batal');
});



Route::get('/penjualan', function () {
    return view('penjualan');
})->name('penjualan');
