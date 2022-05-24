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

        // kalau buka transaksi dari notifikasi masuk didalam when, f = filter
        // chain query
        $trans = Payment::when(array_key_exists('f', $url_query), function($query) use($user) {
            $order_ids = array_column(array_column($user->unreadNotifications()->where('type', 'App\\Notifications\\Admin\\UserPaymentSuccessNotification')->get()->toArray(), 'data'), 'kode_pembayaran');
            $user->notifications()->where('type', 'App\\Notifications\\Admin\\UserPaymentSuccessNotification')->get()->markAsRead();
            $query->whereIn('kode_pembayaran', $order_ids);
        })
        ->when(request()->has('s'), function($query) {
            $query->where('kode_pembayaran', 'like', '%'.request('s').'%');
        })
        ->where('total_bayar', '>', 0)->where('status', 2)->whereHas('order')->latest()->paginate(15);

        $trans_in = Payment::whereHas('order', function($query) {
            $query->whereIn('status', ['2','3']);
        })->where('status', 2)->sum('total_bayar');

        $trans_cancel = Payment::whereHas('order', function($query) {
            $query->whereNotIn('status', ['2','3']);
        })->where('total_bayar', '>', 0)->sum('total_bayar');

        $trans_pending = Payment::where('status', 1)->sum('total_bayar');

        $trans_all = Payment::sum('total_bayar');

        $data = [
            'trans' => $trans,
            'saldo_cancel' => $trans_cancel,
            'saldo_pending' => $trans_pending,
            'saldo_in' => $trans_in,
            'saldo_all' => $trans_all,
        ];
        return view('admin-pages.transaksi', $data);
    }
}
