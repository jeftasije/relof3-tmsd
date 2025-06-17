<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $text = Lang::get('team');
       
        return view('employee', compact('employees', 'text'));
    }

    public function show(Employee $employee)
    {
        $employee->load('extendedBiography');
        return view('employeeBiography', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'biography' => 'nullable|string',
            'position' => 'required|string|max:255',
        ]);

        $employee->update([
            'biography' => $validated['biography'],
            'position' => $validated['position'],
        ]);

        return response()->json(['message' => 'Updated']);
    }

    public function uploadImage(Request $request, Employee $employee)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // max 2MB
        ]);

        $path = $request->file('image')->store('images', 'public'); // snima u storage/app/public/images

        // Opcionalno možeš odmah update baze, ili samo vrati putanju, pa update kad se klikne save u frontendu
        // $employee->image_path = 'storage/' . $path;
        // $employee->save();

        return response()->json(['path' => 'storage/' . $path]);
    }

    public function destroy(Employee $employee)
    {
        // if ($employee->image_path && File::exists(public_path($employee->image_path))) {
        //     File::delete(public_path($employee->image_path));
        // }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Zaposleni je uspešno obrisan.');
    }
}
