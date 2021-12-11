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
}
