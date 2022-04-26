<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use Carbon\carbon;
use App\Classes\PaymentDate;
use App\Mail\PaymentRemainderEmail;

class BounsPaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bounsreminder:cron';

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
        $amount = $remainderdates->getAllPayments(Carbon::now()->format('M'))['Bonus_total'];
        //send mail to admin with amount
        $mailData = [
            'title' => 'Payment Bouns Required',
            'body' => 'you have to pay amount ' . $amount . '  bouns Payment after two days.'
        ];
         
        Mail::to('admin@gmail.com')->send(new PaymentRemainderEmail($mailData));

        return 0;
    }
}
