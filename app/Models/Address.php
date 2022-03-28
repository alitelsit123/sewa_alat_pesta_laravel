<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $primaryKey = 'id_address';
    protected $fillable = [
        'alamat', 'lat', 'lng', 'default', 'id_profile'
    ];

    public function profile() {
        return $this->belongsTo('App\Models\Profile', 'id_profile');
    }
}
