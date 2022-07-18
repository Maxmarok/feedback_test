<?php

namespace App\Listeners;

use App\Http\Controllers\UserController;
use App\Jobs\RepeatSendingJob;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Support\Facades\Log;

class SendNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Notifications\Events\NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSending $event)
    {
        if($event->channel === 'mail') {
            $user = (new UserController($event->notifiable->id))->checkDelivery();

            if($user) {
                RepeatSendingJob::dispatch($event->notification->id)->delay(env('REPEAT_SENDING_TIME'));
            } else {
                Log::error('Daily delivery count exceeded!');
            }
        }
    }
}
