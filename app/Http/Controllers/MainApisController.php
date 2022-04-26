<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use DB;
use Carbon\carbon;

class MainApisController extends Controller
{
    public function changeBounsPercentage(Request $request,Employee $employee) {
        $employee->update(['bouns_percentages' => $request->percentages]);
        $response = [
            'status'=>1,
            'message'=>"bouns percentages changed successfully",
            'data'=> $employee,
        ];
        return response()->json($response);
    }

    public function getAllPayments(Request $request) {
        $employees = DB::table('employees')
                    ->select(DB::raw('sum(salary) as Salaries_total ,sum(bouns_percentages*salary) as Bonus_total'))
                    ->first();        
        $currentMonth = Carbon::now();
        $Salaries_total = (float)$employees->Salaries_total;
        $Bonus_total = (float)$employees->Bonus_total;
        $list = [];
        $index = $currentMonth->format('M');
        
        do {
            $list [$index]["month"] = $currentMonth->format('M');
        
            if($currentMonth->endOfMonth()->format('D') == "Fri"){ 
                 $list[$index]["Salaries_payment_day"] = $currentMonth->endOfMonth()->format('d') - 1;
            }
            elseif($currentMonth->endOfMonth()->format('D') == "Sat"){
                 $list[$index]["Salaries_payment_day"] = $currentMonth->endOfMonth()->format('d') - 2;
            }
            else { 
                 $list[$index]["Salaries_payment_day"] = (int)$currentMonth->endOfMonth()->format('d') ;
            }
            if($currentMonth->startOfMonth()->addDay(14)->format('D') == "Fri" or $currentMonth->startOfMonth()->addDay(14)->format('D') == "Sat"){ 
                 $list[$index]["Bouns_payment_day"] = (int)$currentMonth->startOfMonth()->addDay(14)->next(Carbon::THURSDAY)->format('d');
            }
            else $list[$index]["Bouns_payment_day"] = (int)$currentMonth->startOfMonth()->addDay(14)->format('d');

            //initialize month to be from start 
            $currentMonth->startOfMonth();
            //index
            $currentMonth->addMonths(1)->format('M');
            $list [$index]["Salaries_total"] = $Salaries_total;
            $list [$index]["Bonus_total"]    = $Bonus_total;
            $list [$index]["Payments_total"] = $Salaries_total + $Bonus_total;
            $index = $currentMonth->format('M');
        }
        while((int)$currentMonth->format('n') !=  1);

        if($request->month){
            return $list[$request->month];
        }

        return $list;
    }
}
