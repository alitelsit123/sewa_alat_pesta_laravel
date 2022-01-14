<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatSesi;

class CollectorController extends Controller
{
    public function collectSesi() {
        if(!auth()->check()) {
            return response()->json(['sesi' => null]);    
        }
        return response()->json(['sesi' => ChatSesi::with(['chats', 'user' => function($query) {
            return $query->with(['profile']);
        }])->get()]);
    }
    public function collectUserSesi() {
        if(!auth()->check()) {
            return response()->json(['sesi' => null]);    
        }
        return response()->json(['sesi' => ChatSesi::with(['chats'])->where('id_user', auth()->user()->id_user)->first()]);
    }
    public function collectUser() {
        if(!auth()->check()) {
            return response()->json(['user' => null]);    
        }
        return response()->json(['user' => User::with(['profile'])->where('id_user', auth()->user()->id_user)->first()]);
    }
}
