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
    public function getPhoto() {
        if($this->photo == '' || $this->photo == null) {
            return 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png';
        } else {
            return url('/assets/uploads/users').'/'.$this->photo;
        }
        return url('/assets/uploads/users').'/'.$this->photo;
    }
    
}
