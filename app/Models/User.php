<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $attributes = [
        'role' => '-1',
        'online' => '0',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile() {
        return $this->hasOne('App\Models\Profile', 'id_user');
    }
    public function getPhoto() {
        if($this->profile->photo == '' || $this->profile->photo == null) {
            return 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';
        } else {
            return url('/assets/uploads/users').'/'.$this->profile->photo;
        }
        return url('/assets/uploads/users').'/'.$this->profile->photo;
    }


    public function roles() {
        return $this->belongsToMany('App\Models\UserRole', 'user_roles_pivot', 'id_user', 'id_role')->withTimestamps();
    }

    public function carts() {
        return $this->belongsToMany('App\Models\Produk', 'keranjang', 'id_user', 'id_produk')->withPivot('kuantitas')->withTimestamps();
    }
    public function cartWithStat($produk = null) {
        $stats = ['total_kuantitas' => 0, 'total_harga' => 0];
        $keranjangs = $produk ? $this->carts->whereIn('id_produk', $produk): $this->carts;
        $keranjangs_array = $keranjangs->toArray();
        $keranjangs_array = array_map(function($item){
            $item['total'] = $item['harga'] * $item['pivot']['kuantitas'];
            return $item;
        },$keranjangs_array);
        $keranjangs_pivot = array_map(function($item){
            return $item['pivot'];
        },$keranjangs_array);

        $keranjang_total_kuantitas = array_sum(array_column($keranjangs_pivot, 'kuantitas'));
        
        $keranjang_total_price = array_sum(array_column($keranjangs_array, 'total'));

        $stats['total_kuantitas'] = $keranjang_total_kuantitas;
        $stats['total_harga'] = $keranjang_total_price;

        return [
            'keranjangs' => $keranjangs_array,
            'stat' => $stats,
        ];
    }

    public function order() {
        return $this->hasMany('App\Models\Pesanan', 'id_user')->latest();
    }
    public function orderWithFilter($tipe = null) {
        if($tipe == 1 || $tipe == 2) {
            return $this->order()->whereIn('status', [1,2])->get();
        } else if($tipe == 3) {
            return $this->order()->whereStatus(3)->get();
        } else if($tipe == 4) {
            return $this->order()->whereStatus(4)->get();
        }
        return $this->order;
    }

    public function isAdmin() {
        $role_validator = $this->roles()->whereTipe(2)->first();
        if($role_validator) {
            return true;
        }
        return false;
    }

    public function sesiChat() {
        if($this->isAdmin()) {
            return $this->hasMany('App\Models\ChatSesi', 'id_admin');
        } else {
            return $this->hasOne('App\Models\ChatSesi', 'id_user');
        }
    }
}
