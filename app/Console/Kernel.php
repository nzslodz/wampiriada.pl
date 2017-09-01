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
         Commands\ImportExcelData::class,
         Commands\RegenerateTileImage::class,
         Commands\DispatchWampiriadaMailing::class,
         Commands\RemoveOldActivities::class,
         Commands\TryToDetermineGender::class,
         Commands\DispatchReminderEmails::class,
    ];

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Commands\DispatchReminderEmails::class)
            ->dailyAt('17:00');
    }
}
