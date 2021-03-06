<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Classes\PaymentDate;
use Illuminate\Support\Facades\Log;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    { 
        $remainderdates = new PaymentDate(); 
        $schedule->command('salaryreminder:cron')->monthlyOn($remainderdates->getReminderDateTwoDaysBeforeSalaryPayment(), '00:00');
        $schedule->command('bounsreminder:cron')->monthlyOn($remainderdates->getReminderDateTwoDaysBeforeBounsPayment(), '00:00');
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
