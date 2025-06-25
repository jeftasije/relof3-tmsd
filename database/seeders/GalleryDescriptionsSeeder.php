<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryDescription;


class GalleryDescriptionsSeeder extends Seeder
{
    public function run(): void
    {
        GalleryDescription::updateOrCreate([
            'value' => 'Kroz fotografije i video zapise zaviri u naš svet. Otkrij priče koje inspirišu i trenutke vredne pamćenja.',
            'value_en' => 'A glimpse into our world through photos and videos. Discover stories that inspire and moments worth remembering.',
            'value_cy' => 'Кроз фотографије и видео записе завири у наш свет. Откриј приче које инспиришу и тренутке вредне памћења.'
        ]);
    }
}
