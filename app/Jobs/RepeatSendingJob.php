<?php

namespace App\Jobs;

use App\Http\Controllers\UserController;
use App\Mail\SendContactsMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RepeatSendingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    var $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification = DB::table('notifications')->find($this->id);
        $user = (new UserController($notification->notifiable_id))->checkDelivery();

        if($user && !$notification->read_at) {
            new SendContactsMail($notification->data);
            self::dispatch($this->id)->delay(env('REPEAT_SENDING_TIME'));
        }
    }
}
