<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
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
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $validated = $request->validate([
                'biography' => 'nullable|string',
                'position' => 'required|string|max:255',
            ]);
            $employee->update([
                'biography_cy' => $validated['biography'],
                'position_cy' => $validated['position'],
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

    public function uploadImage(Request $request, Employee $employee)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        try {
            if ($employee->image_path && File::exists(public_path($employee->image_path))) {
                File::delete(public_path($employee->image_path));
            }

            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            $employee->image_path = 'images/' . $filename;
            $employee->save();

            return response()->json([
                'success' => true,
                'employee' => [
                    'image_path' => asset($employee->image_path),
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Greška pri uploadu slike: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Zaposleni je uspešno obrisan.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'position_cy' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'biography_en' => 'nullable|string',
            'biography_cy' => 'nullable|string',
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
                'biography_en' => '',
                'biography_cy' => '',
                'university' => '',
                'university_en' => '',
                'university_cy' => '',
                'experience' => '',
                'experience_en' => '',
                'experience_cy' => '',
                'skills' => [],
                'skills_en' => [],
                'skills_cy' => [],
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
                'biography_en' => 'nullable|string',
                'university_en' => 'nullable|string|max:255',
                'experience_en' => 'nullable|string',
                'skills_en' => 'nullable|string',
            ]);
            $updateData = [
                'biography_translated' => $validated['biography_translated'] ?? null,
                'university_translated' => $validated['university_translated'] ?? null,
                'experience_translated' => $validated['experience_translated'] ?? null,
                'skills_translated' => !empty($validated['skills_translated']) ? array_map('trim', explode(',', $validated['skills_translated'])) : [],
                'biography_en' => $validated['biography_en'] ?? null,
                'university_en' => $validated['university_en'] ?? null,
                'experience_en' => $validated['experience_en'] ?? null,
                'skills_en' => !empty($validated['skills_en']) ? array_map('trim', explode(',', $validated['skills_en'])) : [],
            ];
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $validated = $request->validate([
                'biography_cy' => 'nullable|string',
                'university_cy' => 'nullable|string|max:255',
                'experience_cy' => 'nullable|string',
                'skills_cy' => 'nullable|string',
            ]);
            $updateData = [
                'biography_cy' => $validated['biography_cy'] ?? null,
                'university_cy' => $validated['university_cy'] ?? null,
                'experience_cy' => $validated['experience_cy'] ?? null,
                'skills_cy' => !empty($validated['skills_cy']) ? array_map('trim', explode(',', $validated['skills_cy'])) : [],
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
                'skills' => !empty($validated['skills']) ? array_map('trim', explode(',', $validated['skills'])) : [],
            ];
        }

        $employee->extendedBiography->update($updateData);

        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Extended biography updated successfully.');
    }

}