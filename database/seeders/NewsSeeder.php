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
                'title_en' => 'New Reading Room Opened at the National Library',
                'summary' => 'Nova savremena čitaonica je otvorena u prostorijama biblioteke.',
                'summary_en' => 'A new modern reading room has been opened in the library premises.',
                'image_path' => 'images/news1.jpeg',
                'author' => 'Jelena Petrović',
                'published_at' => '2025-05-15',
            ],
            [
                'title' => 'Predavanje o istoriji Srpske književnosti',
                'title_en' => 'Lecture on the History of Serbian Literature',
                'summary' => 'Organizovano predavanje sa stručnim predavačem iz oblasti književnosti.',
                'summary_en' => 'An organized lecture with an expert speaker in literature.',
                'image_path' => 'images/news2.jpeg',
                'author' => 'Marko Jovanović',
                'published_at' => '2025-04-20',
            ],
            [
                'title' => 'Radionica digitalne pismenosti za odrasle',
                'title_en' => 'Digital Literacy Workshop for Adults',
                'summary' => 'Biblioteka organizuje radionicu za unapređenje digitalnih veština.',
                'summary_en' => 'The library organizes a workshop to improve digital skills.',
                'image_path' => 'images/news3.jpeg',
                'author' => 'Ivana Nikolić',
                'published_at' => '2025-03-10',
            ],
            [
                'title' => 'Izložba retkih knjiga iz fonda Narodne biblioteke',
                'title_en' => 'Exhibition of Rare Books from the National Library Collection',
                'summary' => 'Pogledajte izložbu najvrednijih knjiga iz bibliotečkog fonda.',
                'summary_en' => 'See the exhibition of the most valuable books from the library collection.',
                'image_path' => 'images/news4.jpeg',
                'author' => 'Petar Stanojević',
                'published_at' => '2025-02-25',
            ],
            [
                'title' => 'Nove elektronske knjige dostupne za članove biblioteke',
                'title_en' => 'New E-books Available for Library Members',
                'summary' => 'Dodato je preko 200 novih naslova u elektronskom formatu.',
                'summary_en' => 'Over 200 new titles have been added in electronic format.',
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