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
            'vesti',
            'zaposleni',
            'zalbe',
            'organizaciona-struktura',
            'nabavke',
        ];

        foreach ($pages as $slug) {
            Page::create([
                'title' => ucfirst($slug),
                'slug' => $slug,
                'template_id' => null,
                'content' => null,
                'is_active' => true,
                'is_deletable' => false,
            ]);
        }
    }
}
