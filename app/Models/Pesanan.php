<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $primaryKey = 'kode_pesanan';

    public $incrementing = false;
    protected $fillable = [
        'kode_pesanan',
        'total_pending_bayar',
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
        return $this->payment->first()->tipe_pembayaran;
    }
    public function dpPayment() {
        return $this->payment->where('tipe_pembayaran', 1)->first()->status == 2;
    }
    public function fullPayment() {
        $payment_obj = $this->payment->where('tipe_pembayaran', 2)->first();
        if($payment_obj) {
            return $payment_obj->status == 2;
        }
        return false;
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
    
    public function statusText() {
        if($this->status == 1) {
            return 'menunggu pembayaran';
        } else if($this->status == 2) {
            return 'pending';
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
