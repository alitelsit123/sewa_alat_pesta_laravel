<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'gambar',
        'keterangan',
        'harga',
        'stok',
        'id_kategori',
    ];

    // protected $hidden = [
    //     'final_stok',
    // ];

    public function kategori() {
        return $this->belongsTo('App\Models\Kategori', 'id_kategori');
    }

    // public function getFinalStokAttribute()
    // {
    //     $this->attributes['final_stok'] = $this->stok - $this->ordered->sum('kuantitas');
    // }
    
    public function ordered() {
        return $this->hasMany('App\Models\DetailPesanan', 'id_produk')->when(session()->has('book'), function($query) {
            $query->whereDoesntHave('order', function($scope_query) {
                $scope_query->where([['tanggal_mulai', '>', session('book')['from']], ['tanggal_mulai', '<', session('book')['to']]])
                ->orWhere([['tanggal_selesai', '>', session('book')['from']], ['tanggal_selesai', '<', session('book')['to']]])
                ->orWhere([['tanggal_mulai', '<', session('book')['from']], ['tanggal_selesai', '>', session('book')['to']]]);
            })->whereHas('order.sewa', function($scope_query) {
                $scope_query->where('status', '<', 4);
            });
        });
    }

    // buat cari produk berdasarkan stok di tanggal sekian

    // untuk yg tanpa filter tanggal ambil semua kuantitas produk dari orderan trus dikurangi stok produk jika hasilnya minus atau nol menampilkan stok habis
    // kok bisa minus ? misal total stok produk A = 2, tgl 24-25 dipinjam 2, tgl 27-28 dipinjam 2 jadi 2-4 = -2, 
    // berati produk A habis

    public function scopeWithOrdered($query) {
        $sql = \Str::replaceArray('?', $this->ordered()->getBindings(), $this->ordered()->toSql());
        if(session()->has('book')) {
            $fixed_stok = '(
                select sum(`detail_pesanan`.`kuantitas`) 
                from `detail_pesanan` 
                where `produk`.`id_produk` = `detail_pesanan`.`id_produk` 
                and 
                not exists (
                    select * 
                    from `pesanan` 
                    where `detail_pesanan`.`kode_pesanan` = `pesanan`.`kode_pesanan` 
                    and ((`tanggal_mulai` > '.session('book')['from'].' and `tanggal_mulai` < '.session('book')['to'].') 
                    or (`tanggal_selesai` > '.session('book')['from'].' and `tanggal_selesai` < '.session('book')['to'].') 
                    or (`tanggal_mulai` < '.session('book')['from'].' and `tanggal_selesai` > '.session('book')['to'].')) 
                    and `pesanan`.`deleted_at` is null
                ) and exists (
                    select * 
                    from `pesanan` 
                    where `detail_pesanan`.`kode_pesanan` = `pesanan`.`kode_pesanan` 
                    and exists (
                        select * from `sewa` where `pesanan`.`kode_pesanan` = `sewa`.`kode_pesanan` and `status` < 4 and `sewa`.`deleted_at` is null
                    ) and `pesanan`.`deleted_at` is null
                ) and `detail_pesanan`.`deleted_at` is null
            )';
            return $query
            ->selectRaw('*, CASE WHEN '.$fixed_stok.' IS NULL THEN 0 ELSE '.$fixed_stok.' END AS ordered_sum_kuantitas')        
            ->whereRaw('stok > CASE WHEN '.$fixed_stok.' IS NULL THEN 0 ELSE '.$fixed_stok.' END')
            ;
        } else {
            return $query->withSum('ordered', 'kuantitas');
        }
    }


}
