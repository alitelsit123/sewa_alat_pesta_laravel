<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    protected $fillable = [
        'kuantitas', 'id_user', 'id_produk', 'tanggal_mulai', 'tanggal_selesai'
    ];

    public function produk() {
        return $this->belongsTo('App\Models\Produk', 'id_produk');
    }
}
