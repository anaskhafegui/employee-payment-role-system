<?php

namespace App\Classes;
use DB;
use Carbon\carbon;


class PaymentDate
{
    public $employees;
    public $currentMonth;

    public function __construct() {
       $this->currentMonth = Carbon::now();
    }

    public function getAllPayments($month,$employees)
    {
        $this->employees = $employees;
        $Salaries_total = (float)$this->employees->Salaries_total;
        $Bonus_total = (float)$this->employees->Bonus_total;
        $list = [];
        $index = $this->currentMonth->format('M');

        do {
            $list [$index]["month"]               = $this->currentMonth->format('M');
            $list[$index]["Salaries_payment_day"] = $this->getSalaryPaymentDay($this->currentMonth);
            $list[$index]["Bouns_payment_day"]    = $this->getBounsPaymentDay($this->currentMonth);   
            //initialize month to be from start object passed by reference
            $this->currentMonth->startOfMonth();
           /*  $list [$index]["paymentsReminderDateSalary"] = $this->getReminderDateTwoDaysBeforeSalaryPayment();
            $list [$index]["paymentsReminderDateBouns"]  = $this->getReminderDateTwoDaysBeforeBounsPayment(); */
            //interate next monthes 
            $this->currentMonth->addMonths(1)->format('M');
            $list [$index]["Salaries_total"] = $Salaries_total;
            $list [$index]["Bonus_total"]    = $Bonus_total;
            $list [$index]["Payments_total"] = $Salaries_total + $Bonus_total;
            //hashed by month 
            $index = $this->currentMonth->format('M');
        }
        while((int)$this->currentMonth->format('n') !=  1);

        if($month){
            return $list[$month];
        }
        return $list;
    }
    public static function getCurrentMonth()
    {
        return $this->currentMonth;
    }
    private function getSalaryPaymentDay($month)
    {
        if($month->endOfMonth()->format('D') == "Fri"){ 
           return $this->currentMonth->endOfMonth()->format('d') - 1;
        }
        elseif($month->endOfMonth()->format('D') == "Sat"){
           return $month->endOfMonth()->format('d') - 2;
        }
        else { 
           return (int)$month->endOfMonth()->format('d');
        }
    }
    private function getBounsPaymentDay($month)
    {
        if($month->startOfMonth()->addDay(14)->format('D') == "Fri" or $month->startOfMonth()->addDay(14)->format('D') == "Sat"){ 
            return  (int)$month->startOfMonth()->addDay(14)->next(Carbon::THURSDAY)->format('d');
        }
        else return (int)$month->startOfMonth()->addDay(14)->format('d');
    }
    public  function getReminderDateTwoDaysBeforeSalaryPayment()
    { 
       return $this->getSalaryPaymentDay($this->currentMonth) - 2;
    }
    public  function getReminderDateTwoDaysBeforeBounsPayment()
    {
        return $this->getBounsPaymentDay($this->currentMonth) - 2;
    } 
    
}
