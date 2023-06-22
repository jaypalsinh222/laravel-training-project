<?php

namespace App\Console\Commands;

use App\Mail\RegisterUserMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//
        $user = User::find(101);
        info($user);
//        $mailData = [
//            "id" => $user->id,
//            "name"=>$user->name,
//        ];
////        //dd($mailData);
//        Mail::to($user->email)->send(new RegisterUserMail($mailData));
//        sleep(2);
    }
}
