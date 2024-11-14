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
        $to = "+380968769849";
        $message = "У меня все хорошо! Сейчас: " . date('d.m.Y H:i');

        $command = sprintf('whatsapp:send-message --to="%s" --message"%s"', $to, $message);

        $schedule->command($command)
            ->everyMinute()
            ->runInBackground()
            ->withoutOverlapping();
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
