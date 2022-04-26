<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use Carbon\carbon;
use App\Classes\PaymentDate;
use App\Mail\PaymentRemainderEmail;

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
        $remainderdates = new PaymentDate(); 
        $amount =  $remainderdates->getAllPayments(Carbon::now()->format('M'))['Salaries_total'];
        //send mail to admin with amount
        $mailData = [
            'title' => 'Salary Payment Required',
            'body' => 'you have to pay amount  ' . $amount . ' salary Payment after two days.'
        ];
         
        Mail::to('admin@gmail.com')->send(new PaymentRemainderEmail($mailData));

        return 0;
    }
}
