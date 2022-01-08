<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatBot extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'chat_bot';
    protected $primaryKey = 'id_chat_bot';
    protected $fillable = [
        'chat','keyword','judul', 'prioritas'
    ];
}
