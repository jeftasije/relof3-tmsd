<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExtendedNews;

class ExtendedNewsSeeder extends Seeder
{
    public function run()
    {
        $extendedNews = [
            [
                'news_id' => 1,
                'content' => 'Narodna biblioteka je dobila novu čitaonicu opremljenu modernim nameštajem i pristupom digitalnim izvorima. Posetioci sada mogu uživati u mirnom prostoru za čitanje i istraživanje.',
                'tags' => json_encode(['čitaonica', 'biblioteka', 'infrastruktura']),
            ],
            [
                'news_id' => 2,
                'content' => 'Predavanje je održano u velikoj sali biblioteke, gde je profesor Dragan izneo ključne momente srpske književnosti kroz vekove, sa posebnim osvrtom na modernizam.',
                'tags' => json_encode(['predavanje', 'književnost', 'istorija']),
            ],
            [
                'news_id' => 3,
                'content' => 'Radionica je bila fokusirana na korišćenje računara, interneta i osnovnih digitalnih alata, sa ciljem da se unaprede digitalne veštine odraslih polaznika.',
                'tags' => json_encode(['radionica', 'digitalna pismenost', 'edukacija']),
            ],
            [
                'news_id' => 4,
                'content' => 'Izložba retkih knjiga obuhvata manuskripte i prve izdanja značajnih dela koja su sačuvana u biblioteci tokom više decenija.',
                'tags' => json_encode(['izložba', 'knjige', 'retko']),
            ],
            [
                'news_id' => 5,
                'content' => 'Članovi biblioteke sada imaju pristup novim elektronskim knjigama koje mogu čitati online ili preuzeti za offline čitanje.',
                'tags' => json_encode(['elektronske knjige', 'digitalni fond', 'biblioteka']),
            ],
        ];

        foreach ($extendedNews as $item) {
            ExtendedNews::create($item);
        }
    }
}
