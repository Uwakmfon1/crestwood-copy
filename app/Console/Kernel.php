<?php

namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('backup:clean')->twiceDaily(0, 12);
         $schedule->command('backup:run --only-db')->twiceDaily(0, 12);
         $schedule->command('stocks:update')->everyFifteenMinutes();
         $schedule->command('investments:distribute-profits')->dailyAt('00:00');  //->everyMinute();;
         $schedule->command('settings:generate')
                    ->everyMinute();
         $schedule->command('investment:settle')
                    ->withoutOverlapping()
                    ->everyMinute();
        $schedule->command('savings:settle')
                    ->withoutOverlapping()
                    ->everyMinute();
         $schedule->command('emails:send')
                    ->withoutOverlapping()
                    ->everyMinute();
         $schedule->command('emails:fail')
                    ->withoutOverlapping()
                    ->everyMinute();
        $schedule->command('transaction:notify')
                    ->withoutOverlapping()
                    ->everyMinute();
        $schedule->command('rate:update')
                    ->withoutOverlapping()
                    ->everyThirtyMinutes();
        $schedule->command('maturity:notify')
                    ->withoutOverlapping()
                    ->dailyAt('00:00');
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
