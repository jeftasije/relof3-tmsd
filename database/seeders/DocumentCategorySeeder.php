<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Statut',
            'Osnivački akti',
            'Godišnji planovi',
            'Izveštaji o radu',
            'Izveštaji o radu organa upravljanja',
            'Informator o radu',
            'Procedura o izboru direktora',
            'Druga akta koja regulišu oblasti etike i integriteta',
        ];

        foreach ($categories as $category) {
            DocumentCategory::create(['name' => $category]);
        }
    }
}
