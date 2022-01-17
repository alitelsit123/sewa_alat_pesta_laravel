<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPesanan extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';
    public $timestamps = false;
    protected $fillable = [
        'kuantitas',
        'id_produk',
        'kode_pesanan',
        'total_harga',
    ];

    public function produk() {
        return $this->belongsTo('App\Models\Produk', 'id_produk');
    }
}
