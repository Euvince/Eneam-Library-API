<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /* $schedule->command('app:create-school-year')->everyTwentySeconds();
        $schedule->command('app:create-configuration')->everyTwentySeconds();
        $schedule->command('app:delete-subscription-after-expiration-date')->everyTwentySeconds(); */
        $schedule->command('app:remind-all-users-of-the-end-of-their-loans-requests')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
