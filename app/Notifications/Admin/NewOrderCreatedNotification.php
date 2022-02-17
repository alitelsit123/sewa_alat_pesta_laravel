<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Models\Pesanan as Order;

class NewOrderCreatedNotification extends Notification
{
    use Queueable;
    public $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        $text = 'Pesanan baru dari user ' . $this->order->user->profile->nama;
        return [
            'kode_pesanan' => $this->order->kode_pesanan,
            'text' => $text,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $text = 'Pesanan baru dari user ' . $this->order->user->profile->nama;
        return new BroadcastMessage([
            'kode_pesanan' => $this->order->kode_pesanan,
            'text' => $text,
            'created_at' => now()
        ]);
    }
}
