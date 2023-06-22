<?php

namespace App\Jobs;

use App\Mail\RegisterUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailData;
//    protected $emails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
//        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //info("job started");
        Mail::to($this->mailData['email'])->send(new RegisterUserMail($this->mailData));
//        dump($this->emails);
//        dd($this->mailData);
//        foreach ($this->mailData as $data) {
////            dd($data);
//            Mail::to($data['email'])->send(new RegisterUserMail($data));
//            sleep(2);
//        }
    }
}
