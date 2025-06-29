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
            $bio_en = $validated['biography'] ?? '';
            $pos_en = $validated['position'];

            $bio_lat = $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($bio_en));
            $pos_lat = $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($pos_en));

            $bio_cy = $lm->latin_to_cyrillic($bio_lat);
            $pos_cy = $lm->latin_to_cyrillic($pos_lat);

            $employee->update([
                'biography_en' => $bio_en,
                'position_en' => $pos_en,
                'biography' => $bio_lat,
                'position' => $pos_lat,
                'biography_cy' => $bio_cy,
                'position_cy' => $pos_cy,
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
        return redirect()->route('employees.index')->with('success', 'Zaposleni je uspešno obrisan.');
    }

    public function store(Request $request)
    {
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
        }

        $name_src = $validated['name'];
        $position_src = $validated['position'];
        $biography_src = $validated['biography'] ?? '';
        $bio_ext_src = $validated['biography_extended'] ?? '';
        $univ_src = $validated['university'] ?? '';
        $exp_src = $validated['experience'] ?? '';
        $skills_src = $validated['skills'] ?? '';
        $skills_arr = array_filter(array_map('trim', preg_split('/[,;]+/', $skills_src)));

        $is_cyrillic = preg_match('/[\p{Cyrillic}]/u', $name_src);

        if ($is_cyrillic) {
            $name_lat = $this->languageMapper->cyrillic_to_latin($name_src);
            $position_lat = $this->languageMapper->cyrillic_to_latin($position_src);
            $biography_lat = $this->languageMapper->cyrillic_to_latin($biography_src);
            $bio_ext_lat = $this->languageMapper->cyrillic_to_latin($bio_ext_src);
            $univ_lat = $this->languageMapper->cyrillic_to_latin($univ_src);
            $exp_lat = $this->languageMapper->cyrillic_to_latin($exp_src);
            $skills_lat = array_map(function ($s) { return $this->languageMapper->cyrillic_to_latin($s); }, $skills_arr);
        } else {
            $name_lat = $name_src;
            $position_lat = $position_src;
            $biography_lat = $biography_src;
            $bio_ext_lat = $bio_ext_src;
            $univ_lat = $univ_src;
            $exp_lat = $exp_src;
            $skills_lat = $skills_arr;
        }

        $name_en = $this->translate->setSource('sr')->setTarget('en')->translate($name_lat);
        $position_en = $this->translate->setSource('sr')->setTarget('en')->translate($position_lat);
        $biography_en = $this->translate->setSource('sr')->setTarget('en')->translate($biography_lat);

        $name_cy = $this->languageMapper->latin_to_cyrillic($name_lat);
        $position_cy = $this->languageMapper->latin_to_cyrillic($position_lat);
        $biography_cy = $this->languageMapper->latin_to_cyrillic($biography_lat);

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

        $bio_ext_translated = $this->translate->setSource('sr')->setTarget('en')->translate($bio_ext_lat);
        $univ_translated    = $this->translate->setSource('sr')->setTarget('en')->translate($univ_lat);
        $exp_translated     = $this->translate->setSource('sr')->setTarget('en')->translate($exp_lat);
        $skills_translated = [];
        foreach ($skills_lat as $skill) {
            $skills_translated[] = $this->translate->setSource('sr')->setTarget('en')->translate($skill);
        }

        $bio_ext_cy = $this->languageMapper->latin_to_cyrillic($bio_ext_lat);
        $univ_cy    = $this->languageMapper->latin_to_cyrillic($univ_lat);
        $exp_cy     = $this->languageMapper->latin_to_cyrillic($exp_lat);
        $skills_cy  = array_map(
            fn($skill) => $this->languageMapper->latin_to_cyrillic($skill),
            $skills_lat
        );

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

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
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

            $bio_lat = $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($bio_en));
            $uni_lat = $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($uni_en));
            $exp_lat = $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($exp_en));
            $skills_lat = array_map(function($s) use ($translate, $lm) {
                return $lm->cyrillic_to_latin($translate->setSource('en')->setTarget('sr')->translate($s));
            }, $skills_en_arr);

            $bio_cy = $lm->latin_to_cyrillic($bio_lat);
            $uni_cy = $lm->latin_to_cyrillic($uni_lat);
            $exp_cy = $lm->latin_to_cyrillic($exp_lat);
            $skills_cy = array_map(fn($s) => $lm->latin_to_cyrillic($s), $skills_lat);

            $updateData = [
                'biography_translated'  => $bio_en,
                'university_translated' => $uni_en,
                'experience_translated' => $exp_en,
                'skills_translated'     => $skills_en_arr,

                'biography'             => $bio_lat,
                'university'            => $uni_lat,
                'experience'            => $exp_lat,
                'skills'                => $skills_lat,

                'biography_cy'          => $bio_cy,
                'university_cy'         => $uni_cy,
                'experience_cy'         => $exp_cy,
                'skills_cy'             => $skills_cy,
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