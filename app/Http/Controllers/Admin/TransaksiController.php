<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran as Payment;

class TransaksiController extends Controller
{
    public function index(Request $request) {
        $url_query = $request->query();
        $user = auth()->user();
        $trans = Payment::when(array_key_exists('f', $url_query), function($query) use($user) {
            $order_ids = array_column(array_column($user->unreadNotifications()->where('type', 'App\\Notifications\\Admin\\UserPaymentSuccessNotification')->get()->toArray(), 'data'), 'kode_pembayaran');            
            $user->notifications()->where('type', 'App\\Notifications\\Admin\\UserPaymentSuccessNotification')->get()->markAsRead();
            $query->whereIn('kode_pembayaran', $order_ids);
        })->where('total_bayar', '>', 0)->where('status', 2)->latest()->paginate(15);
        $data = [
            'trans' => $trans
        ];
        return view('admin-pages.transaksi', $data);
    }
}
