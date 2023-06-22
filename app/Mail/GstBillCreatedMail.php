<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GstBillCreatedMail extends Mailable implements ShouldQueue
{
    public $gstData;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gstData)
    {
        $this->gstData = $gstData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Gst Bill Created')->markdown('emails.userGstBillCreated',['gstData'=>$this->gstData]);
    }
}
