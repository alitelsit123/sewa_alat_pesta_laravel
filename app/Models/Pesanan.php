<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pesanan';
    protected $primaryKey = 'kode_pesanan';
    protected $keyType = 'string';

    public $incrementing = false;
    protected $fillable = [
        'kode_pesanan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'total_bayar',
        'id_user',
    ];

    public function details() {
        return $this->hasMany('App\Models\DetailPesanan', 'kode_pesanan');
    }
    public function payment(){
        return $this->hasMany('App\Models\Pembayaran', 'kode_pesanan');
    }
    public function selectedPayment() {
        $dp = $this->payment()->where('tipe_pembayaran', 1)->first();
        return $dp->total_bayar > 0 ? 'dp': 'full';
    }
    public function dpPayment() {
        return $this->payment()->where('tipe_pembayaran', 1)->first();
    }
    public function fullPayment() {
        return $this->payment()->where('tipe_pembayaran', 2)->first();
    }
    public function paymentPending() {
        return $this->payment()->whereStatus(1)->get();
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function sewa() {
        return $this->hasOne('App\Models\Sewa', 'kode_pesanan');
    }
    
    public function hapus() {
        $this->payment()->delete();
        $this->details()->delete();
        $this->sewa()->delete();
        $this->delete();
    }
    public function statusText() {
        if($this->status == 1) {
            return 'menunggu pembayaran';
        } else if($this->status == 2) {
            return 'pembayaran dp';
        } else if($this->status == 3) {
            return 'sukses';
        }
        return 'kedaluarsa';
    }
    public function badge() {
        if($this->status == 1) {
            return 'badge-info';
        } else if($this->status == 2) {
            return 'badge-warning';
        } else if($this->status == 3) {
            return 'badge-success';
        }
        return 'badge-danger';
    }
}
