<?php

namespace App\Notifications\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Models\Pembayaran as Payment;

class PaymentVerifiedNotification extends Notification
{
    use Queueable;

    public $payment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        if($this->payment->order->selectedPayment() == 'dp' && $this->payment->tipe_pembayaran == 2) {
            $tipe = 'pelunasan';
        }
        $tipe = $this->payment->getTipe();
        $text = 'Yeay pembayaran <span class="tx-medium">'.$tipe.'</span> untuk pesanan '.$this->payment->order->kode_pesanan.' diverifikasi.';
        return [
            'kode_pembayaran' => $this->payment->kode_pembayaran,
            'text' => $text,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     * @param needed in frontend image,url
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        $text = '';
        if($this->payment->status == 2) {
            if($this->payment->order->selectedPayment() == 'dp' && $this->payment->tipe_pembayaran == 2) {
                $tipe = 'pelunasan';
            }
            $tipe = $this->payment->getTipe();
            $text = 'Yeay pembayaran <span class="tx-medium">'.$tipe.'</span> untuk pesanan '.$this->payment->order->kode_pesanan.' diverifikasi.';    
        } else if($this->payment->status == 3) {
            if($this->payment->order->selectedPayment() == 'dp' && $this->payment->tipe_pembayaran == 2) {
                $tipe = 'pelunasan';
            }
            $tipe = $this->payment->getTipe();
            $text = 'Maaf Pembayaran <span class="tx-medium">'.$tipe.'</span> untuk pesanan '.$this->payment->order->kode_pesanan.' kedaluarsa.';        
        }
        return new BroadcastMessage([
            'kode_pembayaran' => $this->payment->kode_pembayaran,
            'text' => $text,
            'created_at' => now()
        ]);
    }
}
