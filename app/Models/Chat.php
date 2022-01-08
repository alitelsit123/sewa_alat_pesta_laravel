<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chat';
    protected $primaryKey = 'id_chat';
    protected $fillable = [
        'chat', 'id_chat_sesi', 'pengirim'
    ];
}