<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;
    protected $payment;

    public function __construct($payment)
    {
        parent::__construct();

        $this->payment = $payment;
        $this->order = $this->payment->order;
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
                'order_id' => (string)$this->payment->kode_pembayaran,
                'gross_amount' => $this->payment->total_bayar,
            ],
            'item_details' => [
                [
                    'id' => \uniqid(),
                    'price' => $this->payment->total_bayar,
                    'quantity' => 1,
                    'name' => 'Pembayaran '.$this->payment->getTipe()
                ]
            ],
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