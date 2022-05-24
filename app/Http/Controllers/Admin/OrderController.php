<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;

use App\Notifications\Order\ShipmentNotification;
use App\Notifications\Admin\UserPaymentSuccessNotification;
use App\Notifications\Order\PaymentVerifiedNotification as OrderPaymentNotification;

use App\Models\Pesanan as Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index(Request $request) {
        $url_query = $request->query();
        $user = auth()->user();
        $orders = Order::when(array_key_exists('f', $url_query), function($query) use($user) {
            $order_ids = array_column(array_column($user->unreadNotifications()->where('type', 'App\\Notifications\\Admin\\NewOrderCreatedNotification')->get()->toArray(), 'data'), 'kode_pesanan');
            $user->notifications()->where('type', 'App\\Notifications\\Admin\\NewOrderCreatedNotification')->get()->markAsRead();
            $query->whereIn('kode_pesanan', $order_ids);
        })->when(request()->has('s'), function($query) {
            $query->whereHas('user', function($query) {
                $query->whereHas('profile', function($query2) {
                    $query2->where('nama', 'like', '%'.request('s').'%');
                });
            })->orWhere('kode_pesanan', request('s'));
        })->latest()->paginate(15);
        $data = [
            'orders' => $orders
        ];
        return view('admin-pages.pesanan', $data);
    }

    // tampil detail pesanan
    public function show($kode_pesanan) {
        $order = Order::findOrFail($kode_pesanan);
        $data = [
            'order' => $order
        ];
        return view('admin-pages.pesanan.lihat-pesanan', $data);
    }

    public function destroy($kode_pesanan) {
        $order = Order::where('kode_pesanan', $kode_pesanan)->firstOrFail();
        $order->hapus();
        return redirect(route('admin.order.index'));
    }

    // admin kirim
    public function shipmentOut($kode_pesanan, $type) {
        $order = Order::find($kode_pesanan);
        $user = $order->user;
        $sewa = $order->sewa;
        $sewa->status = $type;
        if($type == 2) {
            $sewa->waktu_pengiriman = now();

            $notification = new ShipmentNotification($sewa);
            $user->notify($notification);
        }
        $sewa->save();

        return redirect(route('admin.order.show', $kode_pesanan));
    }

    // admin kirim
    public function confirmPayment($kode_pesanan, $type, $type_payment) {
        $order = Order::find($kode_pesanan);
        $payment = $order->{$type_payment.'Payment'}();
        $user = $order->user;
        if($payment->status == 1) {
            $sewa = $order->sewa;
            if(!$sewa) {
                $sewa = $order->sewa()->create([
                    'status' => 1,
                ]);
            }

            if($payment->tipe_pembayaran == 1) {
                $rest_payment = $order->fullPayment();
                $midtrans = new CreateSnapTokenService($rest_payment);
                $snapToken = $midtrans->getSnapToken();

                $rest_payment->snap_token = $snapToken;
                $rest_payment->save();
                $order->status = 2;
            } else {
                $order->status = 3;
            }

            $payment->status = 2;

            $order->save();
            $payment->save();

            $user_admins = User::admins()->get();
            foreach($user_admins as $row) {
                $notification_admin = new UserPaymentSuccessNotification($payment);
                $row->notify($notification_admin);
            }
            $notification = new OrderPaymentNotification($payment);
            $user->notify($notification);
        }

        return redirect(route('admin.order.show', $kode_pesanan))->with('notes', ['text' => 'Pembayaran diverifikasi!']);
    }
}
