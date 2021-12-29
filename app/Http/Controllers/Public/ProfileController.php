<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
    public function showProfilePage($slug) {
        $user = User::where('email', $slug)->orWhereHas('profile', function($q) use ($slug) {
            $q->where('id_profile', $slug);
        })->firstOrFail();
        $data = [
            'user' => $user
        ];
        return view('public-pages.profile', $data);
    }
}
