<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'vesti',
                'title' => 'Vesti',
                'title_en' => 'News',
                'title_cy' => 'Вести',
            ],
            [
                'slug' => 'zaposleni',
                'title' => 'Zaposleni',
                'title_en' => 'Employees',
                'title_cy' => 'Запослени',
            ],
            [
                'slug' => 'zalbe',
                'title' => 'Žalbe',
                'title_en' => 'Complaints',
                'title_cy' => 'Жалбе',
            ],
            [
                'slug' => 'organizaciona-struktura',
                'title' => 'Organizaciona struktura',
                'title_en' => 'Organizational Structure',
                'title_cy' => 'Организациона структура',
            ],
            [
                'slug' => 'nabavke',
                'title' => 'Nabavke',
                'title_en' => 'Procurements',
                'title_cy' => 'Набавке',
            ],
        ];

        foreach ($pages as $page) {
            Page::create([
                'title' => $page['title'],
                'title_en' => $page['title_en'],
                'title_cy' => $page['title_cy'],
                'slug' => $page['slug'],
                'template_id' => null,
                'content' => null,
                'content_en' => null,
                'content_cy' => null,
                'is_active' => true,
                'is_deletable' => false,
            ]);
        }
    }
}
