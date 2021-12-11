<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Profile;
use App\Models\UserRole;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth-pages.register');
    }
    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->roles()->syncWithoutDetaching([UserRole::getBasicRole()]);

        return redirect('/auth/login');
    }
}
