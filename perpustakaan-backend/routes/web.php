<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SirkulasiController;
Route::resource('sirkulasi', SirkulasiController::class);
Route::get('/sirkulasi', [SirkulasiController::class, 'index'])->name('sirkulasi.index'); // Menampilkan semua data
Route::post('/sirkulasi', [SirkulasiController::class, 'store'])->name('sirkulasi.store'); // Menambah data baru
Route::patch('/sirkulasi/{id}', [SirkulasiController::class, 'update'])->name('sirkulasi.update'); // Memperbarui status
Route::delete('/sirkulasi/{id}', [SirkulasiController::class, 'destroy'])->name('sirkulasi.destroy'); // Menghapus data