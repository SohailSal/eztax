<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index(Request $request)
    {
        return view('calculator.index');
    }

    public function getSalary(Request $request)
    {
        $salary = $request->json('salary');
        $tax = 0;
        if($salary <= 600000)
        {
            $tax = 0;
        }
        elseif (($salary > 600000) && ($salary <= 1200000))
        {
            $tax = ($salary - 600000) * 0.05;
        }
        elseif (($salary > 1200000) && ($salary <= 2200000))
        {
            $tax = 30000 + ($salary - 1200000) * 0.15;
        }
        elseif (($salary > 2200000) && ($salary <= 3200000))
        {
            $tax = 180000 + ($salary - 2200000) * 0.25;
        }
        elseif (($salary > 3200000) && ($salary <= 4100000))
        {
            $tax = 430000 + ($salary - 3200000) * 0.3;
        }
        else
        {
            $tax = 700000 + ($salary - 4100000) * 0.35;
        }

        return response()->json($tax);
    }
}
