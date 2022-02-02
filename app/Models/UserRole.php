<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama', 'tipe', 'deskripsi', 'status'
    ];

    public static function getBasicRole() {
        return 1;
    }
    public static function getAdminRole() {
        return 1;
    }
    public function user() {
        return $this->belongsToMany('App\Models\User', 'user_roles_pivot', 'id_role', 'id_user')->withTimestamps();
    }
    public function UserAdmin() {
        return $this->user;
    }
}
