<?php

namespace App\Console;

use App\Jobs\SendMailToUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @returnTestCron void
     */
    protected $commands = [
        Commands\TestCron::class,
        Commands\DatabaseBackUp::class,
    ];

    protected function schedule(Schedule $schedule)
    {
//        $schedule->call(function (){
//            info("called every minute");
//        })->everyMinute();

//        $schedule->command('demo:cron')->everyMinute()->runInBackground();
//        $schedule->command('demo:cron')->everyMinute()->runInBackground();
        $schedule->command('demo:cron')
                 ->everyMinute()
                 ->between('6:00', '7:00');
        $schedule->command('db:backup')->everyMinute();
//        $schedule->command('demo:cron')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
