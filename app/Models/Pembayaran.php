<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $primaryKey = 'kode_pembayaran';

    protected $fillable = [
        'kode_pembayaran',
        'snap_token',
        'total_bayar',
        'jenis_pembayaran',
        'tipe_pembayaran',
        'status',
        'kode_pesanan',
    ];

    public function getTipe() {
        return $this->tipe_pembayaran == 1 ? 'Dp': 'Full';
    }
}
