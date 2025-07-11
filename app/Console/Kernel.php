<?php

namespace App\Console;

use App\Jobs\DeleteUnverifiedUsers;
use App\Jobs\FindIncompleteUsers;
use App\Jobs\SendBulkPushNotification;
use App\Jobs\SendEmailNotifications;
use App\Jobs\UpdateChatBoxStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new UpdateChatBoxStatus)->everyTenMinutes();
        $schedule->job(new SendBulkPushNotification)->everyMinute();
        $schedule->command('queue:work --sleep=3 --tries=3 --stop-when-empty')
            ->everyMinute()
            ->withoutOverlapping();
        $schedule->job(new DeleteUnverifiedUsers)->everyTwoHours();
        $schedule->job(new SendEmailNotifications)->everyHour();
        $schedule->job(new FindIncompleteUsers)->everyTwoHours();
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
