<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Statut', 'name_en' => 'Statute'],
            ['name' => 'Osnivački akti', 'name_en' => 'Founding Acts'],
            ['name' => 'Godišnji planovi', 'name_en' => 'Annual Plans'],
            ['name' => 'Izveštaji o radu', 'name_en' => 'Activity Reports'],
            ['name' => 'Izveštaji o radu organa upravljanja', 'name_en' => 'Management Body Reports'],
            ['name' => 'Informator o radu', 'name_en' => 'Information Book'],
            ['name' => 'Procedura o izboru direktora', 'name_en' => 'Director Election Procedure'],
            ['name' => 'Druga akta koja regulišu oblasti etike i integriteta', 'name_en' => 'Other Acts Regulating Ethics and Integrity'],
        ];

        foreach ($categories as $category) {
            DocumentCategory::create($category);
        }
    }
}
