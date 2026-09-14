<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        Transaksi::where('status', 'dipinjam')
            ->whereDate('due_date', '<', now())
            ->update(['status' => 'expired']);

        return view('transaksi', [
            'transaksi' => Transaksi::with(['user', 'buku'])->latest()->get(),
            'user' => User::all(),
            'buku' => Buku::where('stok', '>', 0)->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tgl_pinjam' => 'required|date',
            'due_date' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        $buku = Buku::findOrFail($data['buku_id']);

        if ($buku->stok < 1) {
            return response()->json([
                'message' => 'Stok buku habis.'
            ], 422);
        }

        $data['status'] = 'dipinjam';

        $transaksi = Transaksi::create($data);
        $buku->decrement('stok');

        return response()->json([
            'message' => 'Peminjaman berhasil!',
            'data' => $transaksi->load(['user', 'buku'])
        ], 201);
    }

    public function edit(Transaksi $transaksi)
    {
        return response()->json([
            'data' => $transaksi->load(['user', 'buku'])
        ]);
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tgl_pinjam' => 'required|date',
            'due_date' => 'required|date|after_or_equal:tgl_pinjam',
            'status' => 'required|in:pending,dipinjam,dikembalikan,expired',
        ]);

        $transaksi->update($data);

        return response()->json([
            'message' => 'Transaksi berhasil diupdate!',
            'data' => $transaksi->load(['user', 'buku'])
        ]);
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus!'
        ]);
    }

    public function kembali(Transaksi $transaksi)
    {
        if ($transaksi->status === 'dikembalikan') {
            return response()->json([
                'message' => 'Buku sudah dikembalikan.'
            ], 422);
        }

        $transaksi->update([
            'tgl_kembali' => now()->toDateString(),
            'status' => 'dikembalikan'
        ]);

        $transaksi->buku->increment('stok');

        return response()->json([
            'message' => 'Buku berhasil dikembalikan!',
            'data' => $transaksi->load(['user', 'buku'])
        ]);
    }
}
