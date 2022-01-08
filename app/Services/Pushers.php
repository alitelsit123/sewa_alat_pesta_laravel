<?php

namespace App\Services;

use Pusher\Pusher;

class Pushers {
    protected $app;
    protected $channel;
    protected $config;

    public function __construct($channel, $event) {
        $this->config = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        ];
        $this->app = new Pusher(
			env('PUSHER_APP_KEY'),
			env('PUSHER_APP_SECRET'),
			env('PUSHER_APP_ID'), 
			$this->config
		);
		$this->channel = $channel;
		$this->event = $event;
    }
    public function send($data) {
        $this->app->trigger($this->channel, 'App\\Events\\'.$this->event, $data);
    }
}