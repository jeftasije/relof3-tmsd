<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        $content = file_get_contents(base_path('config/team-content.json'));
        $text = json_decode($content, true);

        return view('employee', compact('employees', 'text'));
    }
                                             

    public function show(Employee $employee)
    {
        $employee->load('extendedBiography');
        return view('employeeBiography', compact('employee'));
    }
}