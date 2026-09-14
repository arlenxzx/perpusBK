<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::count();
        $buku = Buku::count();
        $transaksi = Transaksi::count();
        return view('dashboard', compact('user','buku','transaksi'));
    }
}
