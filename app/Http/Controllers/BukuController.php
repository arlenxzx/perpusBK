<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function index(){
        $buku = Buku::latest()->get();
        return view('buku', compact('buku'));
    }

    public function store(Request $request)
    {
        //val
        $validator = Validator::make($request->all(), [
            'judul'     => 'required',
            'penulis'   => 'required',
            'kategori'   => 'required'
        ]);

        //cek
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $buku = Buku::create([
            'judul'     => $request->judul,
            'penulis'   => $request->penulis,
            'kategori'   => $request->kategori,
            'deskripsi'   => $request->deskripsi,
            'stok'   => $request->stok
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $buku
        ]);
    }
    
    public function edit(Buku $buku)
    {
        return response()->json([
            'success' => true,
            'data' => $buku
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
        ]);

        $buku->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diupdate!',
            'data' => $buku
        ]);
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dihapus!'
        ]);
    }
}
