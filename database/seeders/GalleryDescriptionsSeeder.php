<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GalleryDescription;


class GalleryDescriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GalleryDescription::updateOrCreate(
            ['key' => 'gallery_text'],
            ['value' => 'A glimpse into our world through photos and videos. Discover stories that inspire and moments worth remembering.']
        );
    }
}
