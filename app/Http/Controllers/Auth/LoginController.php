<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth-pages.login');
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required', 'min:8']
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $credentials = $validator->validated();

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            $user = auth()->user(); 
            $user->online = 1;
            $user->save();

            return redirect()->intended('/');
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
        return redirect('/');
    }
}
