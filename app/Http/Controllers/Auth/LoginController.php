<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class LoginController extends Controller
{
    protected $pusher;
    public function __construct()
    {
        $this->pusher = new Pusher(
            config('pusher.APP_KEY'),
            config('pusher.APP_SECRET'),
            config('pusher.APP_ID'),
            [
                'cluster' => config('pusher.APP_CLUSTER'),
                'encrypted' => config('pusher.encrypted'),
            ]
        );
    }
    public function index()
    {
        return view('auth-pages.login');
    }
    public function authorizeWebsocket(Request $request)
    {
        if (!auth()->check()) {
            return response('Forbidden', 403);
        }
        echo $this->pusher->socket_auth(
            $request->input('channel_name'),
            $request->input('socket_id')
        );
        // return true;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()):
            return back()
                ->withErrors($validator)
                ->withInput();
        endif;

        $credentials = $validator->validated();

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();
            $user->online = 1;
            $user->save();

            // if (session()->has('cart') && sizeof(session('cart')) > 0) {
            //     $carts = session('cart');
            //     foreach ($carts as $row):
            //         $user
            //             ->carts()
            //             ->syncWithoutDetaching([
            //                 $row['id_produk'] => [
            //                     'kuantitas' => $row->pivot->kuantitas,
            //                 ],
            //             ]);
            //     endforeach;
            // }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email / Password Salah!!!',
        ]);
    }
    public function logout()
    {
        $user = auth()->user();
        if ($user) {
            $user->online = 0;
            $user->save();
            auth()->logout();
        }
        return redirect('/');
    }
}
