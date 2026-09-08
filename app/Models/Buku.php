<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';
    protected $fillable = [
        'judul',
        'penulis',
        'kategori',
        'stok',
        'deskripsi',
    ];

    public function borrowings()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }
}
