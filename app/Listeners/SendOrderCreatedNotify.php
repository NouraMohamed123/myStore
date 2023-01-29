<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderCreatedNotification;

class SendOrderCreatedNotify
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $store = $event->order->store_id;
        $user = User::where('store_id', $store)->first();

        $user->notify(new OrderCreatedNotification($event->order));

        //more user
        //  $users = User::where('store_id', $store)->get();
        //    Notification::send($users ,new OrderCreatedNotification($event->order));
    }
}