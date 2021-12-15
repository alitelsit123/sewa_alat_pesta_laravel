<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiveChatController extends Controller
{
    public function index() {
        return view('admin-pages.live-chat');
    }
}
