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
                'title_cy' => 'Отворена нова читаоница у Народној библиотеци',
                'summary' => 'Nova savremena čitaonica je otvorena u prostorijama biblioteke.',
                'summary_en' => 'A new modern reading room has been opened in the library premises.',
                'summary_cy' => 'Нова савремена читаоница је отворена у просторијама библиотеке.',
                'image_path' => 'images/news1.jpeg',
                'author' => 'Jelena Petrović',
                'author_en' => 'Jelena Petrovic',
                'author_cy' => 'Јелена Петровић',
                'published_at' => '2025-05-15',
            ],
            [
                'title' => 'Predavanje o istoriji Srpske književnosti',
                'title_en' => 'Lecture on the History of Serbian Literature',
                'title_cy' => 'Предавање о историји Српске књижевности',
                'summary' => 'Organizovano predavanje sa stručnim predavačem iz oblasti književnosti.',
                'summary_en' => 'An organized lecture with an expert speaker in literature.',
                'summary_cy' => 'Организовано предавање са стручним предавачем из области књижевности.',
                'image_path' => 'images/news2.jpeg',
                'author' => 'Marko Jovanović',
                'author_en' => 'Marko Jovanovic',
                'author_cy' => 'Марко Јовановић',
                'published_at' => '2025-04-20',
            ],
            [
                'title' => 'Radionica digitalne pismenosti za odrasle',
                'title_en' => 'Digital Literacy Workshop for Adults',
                'title_cy' => 'Радионица дигиталне писмености за одрасле',
                'summary' => 'Biblioteka organizuje radionicu za unapređenje digitalnih veština.',
                'summary_en' => 'The library organizes a workshop to improve digital skills.',
                'summary_cy' => 'Библиотека организује радионицу за унапређење дигиталних вештина.',
                'image_path' => 'images/news3.jpeg',
                'author' => 'Ivana Nikolić',
                'author_en' => 'Ivana Nikolic',
                'author_cy' => 'Ивана Николић',
                'published_at' => '2025-03-10',
            ],
            [
                'title' => 'Izložba retkih knjiga iz fonda Narodne biblioteke',
                'title_en' => 'Exhibition of Rare Books from the National Library Collection',
                'title_cy' => 'Изложба ретких књига из фонда Народне библиотеке',
                'summary' => 'Pogledajte izložbu najvrednijih knjiga iz bibliotečkog fonda.',
                'summary_en' => 'See the exhibition of the most valuable books from the library collection.',
                'summary_cy' => 'Погледајте изложбу највреднијих књига из библиотечког фонда.',
                'image_path' => 'images/news4.jpeg',
                'author' => 'Petar Stanojević',
                'author_en' => 'Petar Stanojevic',
                'author_cy' => 'Петар Станојевић',
                'published_at' => '2025-02-25',
            ],
            [
                'title' => 'Nove elektronske knjige dostupne za članove biblioteke',
                'title_en' => 'New E-books Available for Library Members',
                'title_cy' => 'Нове електронске књиге доступне за чланове библиотеке',
                'summary' => 'Dodato je preko 200 novih naslova u elektronskom formatu.',
                'summary_en' => 'Over 200 new titles have been added in electronic format.',
                'summary_cy' => 'Додато је преко 200 нових наслова у електронском формату.',
                'image_path' => 'images/news5.jpeg',
                'author' => 'Ana Marković',
                'author_en' => 'Ana Markovic',
                'author_cy' => 'Ана Марковић',
                'published_at' => '2025-01-30',
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}
