<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employee', compact('employees'));
    }                                                 

    public function show(Employee $employee)
    {
        $employee->load('extendedBiography');
        return view('employeeBiography', compact('employee'));
    }
}