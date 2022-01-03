<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $detail_items = $this->order->details;
        $serialized_details = $detail_items->map(function($item){
            return [
                'id' => $item->id_detail_pesanan,
                'price' => $item->produk->harga,
                'quantity' => $item->kuantitas,
                'name' => $item->produk->nama_produk,
            ];
        });
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->kode_pesanan,
                'gross_amount' => $this->order->total_bayar,
            ],
            'item_details' => $serialized_details->toArray(),
            'customer_details' => [
                'first_name' => $this->order->user->profile->nama,
                'email' => $this->order->user->email,
                'phone' => $this->order->user->profile->telepon,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}