<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Controllers\LanguageMapperController;

class EmployeeController extends Controller
{

    public function __construct(LanguageMapperController $languageMapper)
    {
        $this->translate = new GoogleTranslate();
        $this->translate->setSource('sr');
        $this->translate->setTarget('en');

        $this->languageMapper = $languageMapper;
    }

    public function index()
    {
        $employees = Employee::paginate(6);
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
        $translate = $this->translate;
        $lm = $this->languageMapper;
        $locale = app()->getLocale();

        $validated = $request->validate([
            'biography' => 'nullable|string',
            'position' => 'required|string|max:255',
        ]);

        if ($locale === 'en') {
            $employee->update([
                'biography_en' => $validated['biography'] ?? '',
                'position_en' => $validated['position'],
            ]);
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $bio_cy = $validated['biography'] ?? '';
            $pos_cy = $validated['position'];

            $bio_lat = $lm->cyrillic_to_latin($bio_cy);
            $pos_lat = $lm->cyrillic_to_latin($pos_cy);

            $bio_en = $translate->setSource('sr')->setTarget('en')->translate($bio_lat);
            $pos_en = $translate->setSource('sr')->setTarget('en')->translate($pos_lat);

            $employee->update([
                'biography_cy' => $bio_cy,
                'position_cy' => $pos_cy,
                'biography' => $bio_lat,
                'position' => $pos_lat,
                'biography_en' => $bio_en,
                'position_en' => $pos_en,
            ]);
        } else {
            $bio_lat = $validated['biography'] ?? '';
            $pos_lat = $validated['position'];

            $bio_cy = $lm->latin_to_cyrillic($bio_lat);
            $pos_cy = $lm->latin_to_cyrillic($pos_lat);

            $bio_en = $translate->setSource('sr')->setTarget('en')->translate($bio_lat);
            $pos_en = $translate->setSource('sr')->setTarget('en')->translate($pos_lat);

            $employee->update([
                'biography' => $bio_lat,
                'position' => $pos_lat,
                'biography_cy' => $bio_cy,
                'position_cy' => $pos_cy,
                'biography_en' => $bio_en,
                'position_en' => $pos_en,
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
        return redirect()->route('employees.index')->with('success', 'deleted');
    }

    public function store(Request $request)
    {
        $locale = $request->input('locale', 'sr'); 
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'biography_extended' => 'nullable|string',
            'university' => 'nullable|string|max:255',
            'experience' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['image_path'] = 'images/' . $filename;
        } else {
            $validated['image_path'] = 'images/employee-default.jpg'; 
        }

        $name_src = $validated['name'];
        $position_src = $validated['position'];
        $biography_src = $validated['biography'] ?? '';
        $bio_ext_src = $validated['biography_extended'] ?? '';
        $univ_src = $validated['university'] ?? '';
        $exp_src = $validated['experience'] ?? '';
        $skills_src = $validated['skills'] ?? '';
        $skills_arr = array_filter(array_map('trim', preg_split('/[,;]+/', $skills_src)));

        $translate = $this->translate;
        $lm = $this->languageMapper;

        if ($locale === 'en') {
            $name_sr = $translate->setSource('en')->setTarget('sr')->translate($name_src);
            $position_sr = $translate->setSource('en')->setTarget('sr')->translate($position_src);
            $biography_sr = $translate->setSource('en')->setTarget('sr')->translate($biography_src);
            $bio_ext_sr = $translate->setSource('en')->setTarget('sr')->translate($bio_ext_src);
            $univ_sr = $translate->setSource('en')->setTarget('sr')->translate($univ_src);
            $exp_sr = $translate->setSource('en')->setTarget('sr')->translate($exp_src);
            $skills_sr_arr = array_map(function ($tag) use ($translate) {
                return $translate->setSource('en')->setTarget('sr')->translate($tag);
            }, $skills_arr);

            $name_lat = $lm->cyrillic_to_latin($name_sr);
            $position_lat = $lm->cyrillic_to_latin($position_sr);
            $biography_lat = $lm->cyrillic_to_latin($biography_sr);

            $bio_ext_lat = $lm->cyrillic_to_latin($bio_ext_sr);
            $univ_lat = $lm->cyrillic_to_latin($univ_sr);
            $exp_lat = $lm->cyrillic_to_latin($exp_sr);
            $skills_lat = array_map(fn($t) => $lm->cyrillic_to_latin($t), $skills_sr_arr);

            $name_cy = $lm->latin_to_cyrillic($name_lat);
            $position_cy = $lm->latin_to_cyrillic($position_lat);
            $biography_cy = $lm->latin_to_cyrillic($biography_lat);

            $bio_ext_cy = $lm->latin_to_cyrillic($bio_ext_lat);
            $univ_cy = $lm->latin_to_cyrillic($univ_lat);
            $exp_cy = $lm->latin_to_cyrillic($exp_lat);
            $skills_cy = array_map(fn($t) => $lm->latin_to_cyrillic($t), $skills_lat);

            $name_en = $name_src;
            $position_en = $position_src;
            $biography_en = $biography_src;
            $bio_ext_translated = $bio_ext_src;
            $univ_translated = $univ_src;
            $exp_translated = $exp_src;
            $skills_translated = $skills_arr;
        }
        elseif (preg_match('/[\p{Cyrillic}]/u', $name_src)) {
            $name_cy = $name_src;
            $position_cy = $position_src;
            $biography_cy = $biography_src;
            $bio_ext_cy = $bio_ext_src;
            $univ_cy = $univ_src;
            $exp_cy = $exp_src;
            $skills_cy = $skills_arr;

            $name_lat = $lm->cyrillic_to_latin($name_cy);
            $position_lat = $lm->cyrillic_to_latin($position_cy);
            $biography_lat = $lm->cyrillic_to_latin($biography_cy);

            $bio_ext_lat = $lm->cyrillic_to_latin($bio_ext_cy);
            $univ_lat = $lm->cyrillic_to_latin($univ_cy);
            $exp_lat = $lm->cyrillic_to_latin($exp_cy);
            $skills_lat = array_map(fn($t) => $lm->cyrillic_to_latin($t), $skills_cy);

            $name_en = $translate->setSource('sr')->setTarget('en')->translate($name_lat);
            $position_en = $translate->setSource('sr')->setTarget('en')->translate($position_lat);
            $biography_en = $translate->setSource('sr')->setTarget('en')->translate($biography_lat);

            $bio_ext_translated = $translate->setSource('sr')->setTarget('en')->translate($bio_ext_lat);
            $univ_translated = $translate->setSource('sr')->setTarget('en')->translate($univ_lat);
            $exp_translated = $translate->setSource('sr')->setTarget('en')->translate($exp_lat);
            $skills_translated = array_map(fn($t) => $translate->setSource('sr')->setTarget('en')->translate($t), $skills_lat);
        }
        else {
            $name_lat = $name_src;
            $position_lat = $position_src;
            $biography_lat = $biography_src;
            $bio_ext_lat = $bio_ext_src;
            $univ_lat = $univ_src;
            $exp_lat = $exp_src;
            $skills_lat = $skills_arr;

            $name_cy = $lm->latin_to_cyrillic($name_lat);
            $position_cy = $lm->latin_to_cyrillic($position_lat);
            $biography_cy = $lm->latin_to_cyrillic($biography_lat);

            $bio_ext_cy = $lm->latin_to_cyrillic($bio_ext_lat);
            $univ_cy = $lm->latin_to_cyrillic($univ_lat);
            $exp_cy = $lm->latin_to_cyrillic($exp_lat);
            $skills_cy = array_map(fn($t) => $lm->latin_to_cyrillic($t), $skills_lat);

            $name_en = $translate->setSource('sr')->setTarget('en')->translate($name_lat);
            $position_en = $translate->setSource('sr')->setTarget('en')->translate($position_lat);
            $biography_en = $translate->setSource('sr')->setTarget('en')->translate($biography_lat);

            $bio_ext_translated = $translate->setSource('sr')->setTarget('en')->translate($bio_ext_lat);
            $univ_translated = $translate->setSource('sr')->setTarget('en')->translate($univ_lat);
            $exp_translated = $translate->setSource('sr')->setTarget('en')->translate($exp_lat);
            $skills_translated = array_map(fn($t) => $translate->setSource('sr')->setTarget('en')->translate($t), $skills_lat);
        }

        $employee = Employee::create([
            'name'         => $name_lat,
            'name_en'      => $name_en,
            'name_cy'      => $name_cy,
            'position'     => $position_lat,
            'position_en'  => $position_en,
            'position_cy'  => $position_cy,
            'biography'    => $biography_lat,
            'biography_en' => $biography_en,
            'biography_cy' => $biography_cy,
            'image_path'   => $validated['image_path'] ?? null,
        ]);

        $employee->extendedBiography()->create([
            'biography'             => $bio_ext_lat,
            'biography_translated'  => $bio_ext_translated,
            'biography_cy'          => $bio_ext_cy,
            'university'            => $univ_lat,
            'university_translated' => $univ_translated,
            'university_cy'         => $univ_cy,
            'experience'            => $exp_lat,
            'experience_translated' => $exp_translated,
            'experience_cy'         => $exp_cy,
            'skills'                => $skills_lat,
            'skills_translated'     => $skills_translated,
            'skills_cy'             => $skills_cy,
        ]);

        return redirect()->route('employees.index')->with('success', 'added'); 
    }

    public function updateExtendedBiography(Request $request, Employee $employee)
    {
        $translate = $this->translate;
        $lm = $this->languageMapper;
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
            ]);
            $bio_en = $validated['biography_translated'] ?? '';
            $uni_en = $validated['university_translated'] ?? '';
            $exp_en = $validated['experience_translated'] ?? '';
            $skills_en_arr = !empty($validated['skills_translated']) ? array_map('trim', explode(',', $validated['skills_translated'])) : [];

            $updateData = [
                'biography_translated'  => $bio_en,
                'university_translated' => $uni_en,
                'experience_translated' => $exp_en,
                'skills_translated'     => $skills_en_arr,
            ];
        }
        elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $validated = $request->validate([
                'biography_cy' => 'nullable|string',
                'university_cy' => 'nullable|string|max:255',
                'experience_cy' => 'nullable|string',
                'skills_cy' => 'nullable|string',
            ]);
            $bio_cy = $validated['biography_cy'] ?? '';
            $uni_cy = $validated['university_cy'] ?? '';
            $exp_cy = $validated['experience_cy'] ?? '';
            $skills_cy_arr = !empty($validated['skills_cy']) ? array_map('trim', explode(',', $validated['skills_cy'])) : [];

            $bio_lat = $lm->cyrillic_to_latin($bio_cy);
            $uni_lat = $lm->cyrillic_to_latin($uni_cy);
            $exp_lat = $lm->cyrillic_to_latin($exp_cy);
            $skills_lat = array_map(fn($s) => $lm->cyrillic_to_latin($s), $skills_cy_arr);

            $bio_en = $translate->setSource('sr')->setTarget('en')->translate($bio_lat);
            $uni_en = $translate->setSource('sr')->setTarget('en')->translate($uni_lat);
            $exp_en = $translate->setSource('sr')->setTarget('en')->translate($exp_lat);
            $skills_en_arr = array_map(function($s) use ($translate) {
                return $translate->setSource('sr')->setTarget('en')->translate($s);
            }, $skills_lat);

            $updateData = [
                'biography_cy'          => $bio_cy,
                'university_cy'         => $uni_cy,
                'experience_cy'         => $exp_cy,
                'skills_cy'             => $skills_cy_arr,

                'biography'             => $bio_lat,
                'university'            => $uni_lat,
                'experience'            => $exp_lat,
                'skills'                => $skills_lat,

                'biography_translated'  => $bio_en,
                'university_translated' => $uni_en,
                'experience_translated' => $exp_en,
                'skills_translated'     => $skills_en_arr,
            ];
        }
        else {
            $validated = $request->validate([
                'biography' => 'nullable|string',
                'university' => 'nullable|string|max:255',
                'experience' => 'nullable|string',
                'skills' => 'nullable|string',
            ]);
            $bio_lat = $validated['biography'] ?? '';
            $uni_lat = $validated['university'] ?? '';
            $exp_lat = $validated['experience'] ?? '';
            $skills_lat = !empty($validated['skills']) ? array_map('trim', explode(',', $validated['skills'])) : [];

            $bio_cy = $lm->latin_to_cyrillic($bio_lat);
            $uni_cy = $lm->latin_to_cyrillic($uni_lat);
            $exp_cy = $lm->latin_to_cyrillic($exp_lat);
            $skills_cy = array_map(fn($s) => $lm->latin_to_cyrillic($s), $skills_lat);

            $bio_en = $translate->setSource('sr')->setTarget('en')->translate($bio_lat);
            $uni_en = $translate->setSource('sr')->setTarget('en')->translate($uni_lat);
            $exp_en = $translate->setSource('sr')->setTarget('en')->translate($exp_lat);
            $skills_en_arr = array_map(function($s) use ($translate) {
                return $translate->setSource('sr')->setTarget('en')->translate($s);
            }, $skills_lat);

            $updateData = [
                'biography'             => $bio_lat,
                'university'            => $uni_lat,
                'experience'            => $exp_lat,
                'skills'                => $skills_lat,

                'biography_cy'          => $bio_cy,
                'university_cy'         => $uni_cy,
                'experience_cy'         => $exp_cy,
                'skills_cy'             => $skills_cy,

                'biography_translated'  => $bio_en,
                'university_translated' => $uni_en,
                'experience_translated' => $exp_en,
                'skills_translated'     => $skills_en_arr,
            ];
        }

        $employee->extendedBiography->update($updateData);

        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Extended biography updated successfully.');
    }

}