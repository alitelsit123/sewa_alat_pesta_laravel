<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class LoginAdminController extends Controller
{
    public function index()
    {
        return view('auth-pages.login-admin');
    }

    public function login(Request $request) {
        $validator = \Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required']
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $credentials = $validator->validated();

        // $user = User::whereHas('roles', function(Builder $query) {
        //     $query->where('user_roles.tipe', 2);
        // })->where('email', $credentials['email'])->first();

        $user = User::whereEmail($credentials['email'])->first();

        if($user) {
            $role_validator = $user->isAdmin();
            if($role_validator) {
                if (auth()->attempt($credentials)) {
                    $user->online = 1;
                    $user->save();
                    $request->session()->regenerate();
                    return redirect()->intended('/admin');
                }
            } else {
                return back()->withErrors([
                    'email' => 'User tidak terdaftar sebagai Admin!',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email / Password Salah!!!',
        ]);
    }
    public function logout() {
        $user = auth()->user();
        if($user) {
            $user->online = 0;
            $user->save();
            auth()->logout();
        }
        return redirect('/auth/admin/login');
    }
}
