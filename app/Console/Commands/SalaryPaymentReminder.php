<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\PaymentDate;
use Carbon\carbon;

class SalaryPaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salaryreminder:cron';

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

        info("Cron Job running at ". now());

        //send mail to admin
       

        return 0;
    }
}
