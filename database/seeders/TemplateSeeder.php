<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::create([
            'name' => 'hero_story',
            'title' => 'Naslovna priča',
            'title_en' => 'Headline Story',
            'title_cy' => 'Насловна прича',

            'description' => 'Privucite pažnju velikim naslovom, upečatljivom slikom i tekstom ispod. Idealan za stranice kao što su „O nama“, isticanje proizvoda ili servisa.',
            'description_en' => 'Capture attention with a bold title, a large featured image, and descriptive text below. Perfect for “About Us” pages or showcasing products and services.',
            'description_cy' => 'Привуците пажњу великим насловом, упечатљивом сликом и текстом испод. Идеалан за стране као што су „О нама“, истицање производа или услуга.',

            'thumbnail' => '/templates/hero_story.png',
        ]);
    }
}
