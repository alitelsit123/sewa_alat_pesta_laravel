<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\User;

class PollingController extends Controller
{
    public function paymentStatus(Request $request) {
        $input = $request->all();
        $user = User::find($input['user']);

        $orders = $user->order()->where('status', '<', 3)->get();
        $updated_orders = [];
        $any_update = false;
        $r = null;
        foreach($orders as $row) {
            $payment = $row->payment()->where('status', '1')->whereNotNull('snap_token')->first();
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic '.\base64_encode(config('midtrans.server_key')).':'
            ])->get('https://api.sandbox.midtrans.com/v2/'.$payment->kode_pesanan.'/status');
            if($response['status_code'] == 200 && $response['transaction_status'] == 'settlement') {
                array_push($updated_orders, $payment);
                $any_update = true;
            }
            $r = $response->json();
        }

        return response()->json([
            'msg' => 'success',
            'data' => [
                'orders' => $updated_orders,
                'updated' => $any_update,
                'midtrans_response' => $r
            ]
        ]);
    }
}
