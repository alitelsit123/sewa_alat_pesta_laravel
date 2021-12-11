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

        return 'loged in';
    }
}
