<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts/app');
});

Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');


Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

Route::put('/transaksi/{transaksi}/kembali', [TransaksiController::class, 'kembali'])
    ->name('transaksi.kembali');