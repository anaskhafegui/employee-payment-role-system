<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use DB;
use Carbon\carbon;
use App\Classes\PaymentDate;


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
        $remainderdates = new PaymentDate(); 
        return $remainderdates->getAllPayments($request->month);
    }
}
