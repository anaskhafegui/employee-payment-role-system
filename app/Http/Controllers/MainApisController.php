<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class MainApisController extends Controller
{
    public function changebounspercentage(Request $request,Employee $employee) {
        $employee->update(['bouns_percentages' => $request->percentages]);
        $response = [
            'status'=>1,
            'message'=>"bouns percentages changed successfully",
            'data'=> $employee,
        ];
        return response()->json($response);
    }
}
