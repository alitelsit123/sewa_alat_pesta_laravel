<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_profile';

    protected $fillable = [
        'nama',
        'telepon',
        'tanggal_lahir',
        'alamat',
        'kodepos',
        'pekerjaan',
        'photo',
        'id_user',
    ];
    
}
