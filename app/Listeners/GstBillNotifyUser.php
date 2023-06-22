<?php

namespace App\Listeners;

use App\Events\GstBillCreated;
use App\Mail\GstBillCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class GstBillNotifyUser
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
     * @param \App\Events\GstBillCreated $event
     * @return void
     */
    public function handle(GstBillCreated $event)
    {
//        dd($event->gstData['email']);
        Mail::to($event->gstData['email'])->send(new GstBillCreatedMail($event->gstData));
    }
}
