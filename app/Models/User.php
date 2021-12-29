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


    public function roles() {
        return $this->belongsToMany('App\Models\UserRole', 'user_roles_pivot', 'id_user', 'id_role')->withTimestamps();
    }

    public function carts() {
        return $this->belongsToMany('App\Models\Produk', 'keranjang', 'id_user', 'id_produk')->withPivot('kuantitas')->withTimestamps();
    }

    public function isAdmin() {
        $role_validator = $this->roles()->whereTipe(2)->first();
        if($role_validator) {
            return true;
        }
        return false;
    }
}
