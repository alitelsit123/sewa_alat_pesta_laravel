<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sewa extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'sewa';
    protected $primaryKey = 'id_sewa';
    public $timestamps = false;
    protected $fillable = [
        'status',
        'kode_pesanan',
        'waktu_pengiriman',
        'waktu_pengembalian',
        'deleted_at',
    ];
    public function order() {
        return $this->belongsTo('App\Models\Pesanan', 'kode_pesanan');
    }
    public function user() {
        return $this->order ? $this->order->user()->with(['profile'])->first(): null;
    }
    public function getShipmentStatusText() {
        if($this->status == 1) {
            return 'Belum dikirim';
        } else if($this->status == 2) {
            return 'Dikirim';
        }
        return 'Selesai';
    }
    public function getStatusText() {
        if($this->status == 1) {
            return 'Belum dikirim';
        } else if($this->status == 2) {
            return 'Dikirim';
        } else if($this->status == 3) {
            return 'Disewa';
        }

        $has_pending_payment = $this->order->paymentPending()->count();
        if($has_pending_payment) {
            return 'Selesai, Belum Lunas';
        }
        
        return 'Selesai';
    }
}
