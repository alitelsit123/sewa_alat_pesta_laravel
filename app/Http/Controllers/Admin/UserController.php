<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id_user', '<>', auth()->user()->id_user)->get();

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
    public function setAsAdmin($id) {
        $user = User::whereId_user($id)->first();
        $user->roles()->syncWithoutDetaching(2);
        return back()->with('notes', ['text' => 'Berhasil!']);
    }
    public function removeAdminRole($id) {
        $user = User::whereId_user($id)->first();
        $user->roles()->detach(2);
        return back()->with('notes', ['text' => 'Berhasil!']);
    }
}
