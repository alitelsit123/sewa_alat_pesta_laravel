<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pesanan as Order;
use App\Models\Sewa;
use App\Models\User;
use App\Models\Pembayaran as Payment;

use App\Notifications\Order as OrderNotification;
use App\Notifications\Order\PaymentVerifiedNotification as OrderPaymentNotification;

class DashboardController extends Controller
{
    public function index() {
        // $order = Order::first();
        // $user = $order->user;
        // $notification = new OrderPaymentNotification($order->fullPayment());
        // $user->notify($notification);
        // return dd($user->notifications);

        $new_order = Order::whereStatus(1)->count();
        $sewa = Sewa::where('status', '<', 4)->count();
        $pendapatan = Payment::where('status', 2)->get()->sum('total_bayar');
        $user = User::whereDoesntHave('roles', function($query) {
            $query->where('tipe', 2);
        })->count();
        $data = [
            'total_order_baru' => $new_order,
            'total_sewa' => $sewa,
            'total_pendapatan' => $pendapatan,
            'total_user' => $user
        ];
        return view('admin-pages.dashboard', $data);
    }
}