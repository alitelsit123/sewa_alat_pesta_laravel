<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pesanan as Order;
use App\Models\Sewa;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Pembayaran as Payment;

use App\Notifications\Order as OrderNotification;
use App\Notifications\Order\PaymentVerifiedNotification as OrderPaymentNotification;

class DashboardController extends Controller
{
    public function index() {
        $new_order = Order::whereStatus(1)->count();
        $sewa = Sewa::where('status', '<', 4)->count();
        $pendapatan = Payment::whereHas('order', function($query) {
            $query->whereIn('status', ['2','3']);
        })->where('status', 2)->sum('total_bayar');
        $user = User::whereDoesntHave('roles', function($query) {
            $query->where('tipe', 2);
        })->count();

        $dates = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'November', 'December'];

        $trans_in = Payment::whereHas('order', function($query) {
            $query->whereIn('status', ['2','3']);
        })->where('total_bayar', '>', '0')->where('status', 2)->get();

        $trans_in = $trans_in->map(function($item) {
            $dateValue = strtotime($item->created_at);                     
            $mon = date("F", $dateValue);
            return [
                'month' => $mon,
                'data' => $item->total_bayar
            ];
        })->all();

        $trans_pending = Payment::where('status', 1)->get();
        $trans_pending = $trans_pending->map(function($item) {
            $dateValue = strtotime($item->created_at);                     
            $mon = date("F", $dateValue);
            return [
                'month' => $mon,
                'data' => $item->total_bayar
            ];
        })->all();

        $chart_in = [];
        $chart_pending = [];

                
        foreach($dates as $row) {
            $chart_in[$row] = 0;
            $filtered_chart_in = array_filter($trans_in, function($item, $index) use($row) {
                return $item['month'] == $row;
            }, ARRAY_FILTER_USE_BOTH);
            $chart_in[$row] = array_sum(array_column($filtered_chart_in, 'data'));

            $chart_pending[$row] = 0;
            $filtered_chart_pending = array_filter($trans_pending, function($item, $index) use($row) {
                return $item['month'] == $row;
            }, ARRAY_FILTER_USE_BOTH);
            $chart_pending[$row] = array_sum(array_column($filtered_chart_pending,'data'));
        }

        $data = [
            'total_order_baru' => $new_order,
            'total_sewa' => $sewa,
            'total_pendapatan' => $pendapatan,
            'total_user' => $user,
            'chart_in' => array_values($chart_in),
            'chart_pending' => array_values($chart_pending),
            'dates' => $dates
        ];
        return view('admin-pages.dashboard', $data);
    }
}
