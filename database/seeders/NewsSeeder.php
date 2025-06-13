<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $news = [
            [
                'title' => 'Otvorena nova čitaonica u Narodnoj biblioteci',
                'summary' => 'Nova savremena čitaonica je otvorena u prostorijama biblioteke.',
                'image_path' => 'images/news1.jpeg',
                'author' => 'Jelena Petrović',
                'published_at' => '2025-05-15',
            ],
            [
                'title' => 'Predavanje o istoriji Srpske književnosti',
                'summary' => 'Organizovano predavanje sa stručnim predavačem iz oblasti književnosti.',
                'image_path' => 'images/news2.jpeg',
                'author' => 'Marko Jovanović',
                'published_at' => '2025-04-20',
            ],
            [
                'title' => 'Radionica digitalne pismenosti za odrasle',
                'summary' => 'Biblioteka organizuje radionicu za unapređenje digitalnih veština.',
                'image_path' => 'images/news3.jpeg',
                'author' => 'Ivana Nikolić',
                'published_at' => '2025-03-10',
            ],
            [
                'title' => 'Izložba retkih knjiga iz fonda Narodne biblioteke',
                'summary' => 'Pogledajte izložbu najvrednijih knjiga iz bibliotečkog fonda.',
                'image_path' => 'images/news4.jpeg',
                'author' => 'Petar Stanojević',
                'published_at' => '2025-02-25',
            ],
            [
                'title' => 'Nove elektronske knjige dostupne za članove biblioteke',
                'summary' => 'Dodato je preko 200 novih naslova u elektronskom formatu.',
                'image_path' => 'images/news5.jpeg',
                'author' => 'Ana Marković',
                'published_at' => '2025-01-30',
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}
