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
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $validated = $request->validate([
                'biography' => 'nullable|string',
                'position' => 'required|string|max:255',
            ]);
            $employee->update([
                'biography_en' => $validated['biography'],
                'position_en' => $validated['position'],
            ]);
        } else {
            $validated = $request->validate([
                'biography' => 'nullable|string',
                'position' => 'required|string|max:255',
            ]);
            $employee->update([
                'biography' => $validated['biography'],
                'position' => $validated['position'],
            ]);
        }

        return response()->json(['message' => 'Updated']);
    }


    public function uploadImage(Request $request, Employee $employee){
        try {

            $employee->update([
                'biography' => $validated['biography'],
                'position' => $validated['position'],
            ]);
            
            if ($request->hasFile('image')) {
                if ($employee->image_path && Storage::disk('public')->exists($employee->image_path)) {
                    Storage::disk('public')->delete($employee->image_path);
                }
                $employee->image_path = $request->file('image')->store('images', 'public');
                $employee->save();
            }
            return response()->json([
                'success' => true,
                'employee' => [
                    'biography' => $employee->translated_biography,
                    'position' => $employee->translated_position,
                    'image_path' => asset($employee->image_path),
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Greška pri ažuriranju zaposlenog: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Employee $employee)
    {
        // if ($employee->image_path && File::exists(public_path($employee->image_path))) {
        //     File::delete(public_path($employee->image_path));
        // }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Zaposleni je uspešno obrisan.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'biography_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            $validated['image_path'] = 'images/' . $filename; 
        }

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    public function updateExtendedBiography(Request $request, Employee $employee)
    {
        $locale = app()->getLocale();

        if (!$employee->extendedBiography) {
            $employee->extendedBiography()->create([
                'biography' => '',
                'university' => '',
                'experience' => '',
                'skills' => [],
                'biography_translated' => '',
                'university_translated' => '',
                'experience_translated' => '',
                'skills_translated' => [],
            ]);
        }

        if ($locale === 'en') {
            $validated = $request->validate([
                'biography_translated' => 'nullable|string',
                'university_translated' => 'nullable|string|max:255',
                'experience_translated' => 'nullable|string',
                'skills_translated' => 'nullable|string',
            ]);
            $updateData = [
                'biography_translated' => $validated['biography_translated'] ?? null,
                'university_translated' => $validated['university_translated'] ?? null,
                'experience_translated' => $validated['experience_translated'] ?? null,
                'skills_translated' => $validated['skills_translated'] ? array_map('trim', explode(',', $validated['skills_translated'])) : [],
            ];
        } else {
            $validated = $request->validate([
                'biography' => 'nullable|string',
                'university' => 'nullable|string|max:255',
                'experience' => 'nullable|string',
                'skills' => 'nullable|string',
            ]);
            $updateData = [
                'biography' => $validated['biography'] ?? null,
                'university' => $validated['university'] ?? null,
                'experience' => $validated['experience'] ?? null,
                'skills' => $validated['skills'] ? array_map('trim', explode(',', $validated['skills'])) : [],
            ];
        }

        $employee->extendedBiography->update($updateData);

        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Extended biography updated successfully.');
    }
}