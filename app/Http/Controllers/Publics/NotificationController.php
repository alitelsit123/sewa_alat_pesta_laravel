<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead() {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['msg' => '']);
    }
}
