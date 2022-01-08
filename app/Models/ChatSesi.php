<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatSesi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat_sesi';
    protected $primaryKey = 'id_chat_sesi';
    protected $fillable = [
        'id_user', 'id_admin', 'status'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
    public function cs() {
        return $this->belongsTo('App\Models\User', 'id_admin');
    }
    public function chats() {
        return $this->hasMany('App\Models\Chat', 'id_chat_sesi');
    }
    public function hapus() {
        $this->chats()->delete();
        return $this->delete();
    }
}
