<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('extension:stats')->daily();
        $schedule->command('extension:refresh')->daily();
        $schedule->command('extension:db-update')->daily();
        $schedule->command('extension:readme')->daily();

        $schedule->command('page-cache:clear')->dailyAt('0:30');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
