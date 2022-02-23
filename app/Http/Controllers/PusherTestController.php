<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Services\Pushers;
use App\Notifications\Admin\NewOrderCreatedNotification;

use App\Models\User;
use App\Models\Pesanan as Order;

// gakepake, cuma test
class PusherTestController extends Controller
{
    public function notification()
    {
        return '';
    }
}
