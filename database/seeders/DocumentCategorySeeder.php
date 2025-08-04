<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Statut',
                'name_en' => 'Statute',
                'name_cy' => 'Статут',
            ],
            [
                'name' => 'Osnivački akti',
                'name_en' => 'Founding Acts',
                'name_cy' => 'Оснивачки акти',
            ],
            [
                'name' => 'Godišnji planovi',
                'name_en' => 'Annual Plans',
                'name_cy' => 'Годишњи планови',
            ],
            [
                'name' => 'Izveštaji o radu',
                'name_en' => 'Activity Reports',
                'name_cy' => 'Извештаји о раду',
            ],
            [
                'name' => 'Izveštaji o radu organa upravljanja',
                'name_en' => 'Management Body Reports',
                'name_cy' => 'Извештаји о раду органа управљања',
            ],
            [
                'name' => 'Informator o radu',
                'name_en' => 'Information Book',
                'name_cy' => 'Информатор о раду',
            ],
            [
                'name' => 'Procedura o izboru direktora',
                'name_en' => 'Director Election Procedure',
                'name_cy' => 'Процедура о избору директора',
            ],
            [
                'name' => 'Druga akta koja regulišu oblasti etike i integriteta',
                'name_en' => 'Other Acts Regulating Ethics and Integrity',
                'name_cy' => 'Друга акта која регулишу области етике и интегритета',
            ],
        ];

        foreach ($categories as $category) {
            DocumentCategory::create($category);
        }
    }
}