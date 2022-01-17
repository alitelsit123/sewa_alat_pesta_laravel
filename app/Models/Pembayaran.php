<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'pembayaran';
    protected $primaryKey = 'kode_pembayaran';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'kode_pembayaran',
        'snap_token',
        'total_bayar',
        'jenis_pembayaran',
        'tipe_pembayaran',
        'status',
        'kode_pesanan',
    ];

    public function order() {
        return $this->belongsTo('App\Models\Pesanan', 'kode_pesanan');
    }

    public function getTipe() {
        return $this->tipe_pembayaran == 1 ? 'Dp': 'Full';
    }
    

}
