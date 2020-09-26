<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('extension:stats')->dailyAt('0:10');
        $schedule->command('extension:refresh')->daily('0:15');
        $schedule->command('extension:db-update')->daily('0:20');
        $schedule->command('extension:readme')->daily('0:25');
        $schedule->command('page-cache:clear')->dailyAt('0:30');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
