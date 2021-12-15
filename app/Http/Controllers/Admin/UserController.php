<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        $data = [
            'users' => $users
        ];
        return view('admin-pages.pengguna', $data);
    }

    public function showUser($id) {
        $user = User::findOrFail($id);
        $data = [
            'user' => $user
        ];
        return view('admin-pages.user.lihat-user', $data);
    }
}
