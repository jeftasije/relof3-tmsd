<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactContent;

class ContactContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactContent::create([
            'text_sr' => 'Naš tim je tu da odgovori na sva vaša pitanja i obezbedi vam najbolju moguću uslugu!',
            'text_en' => 'Our team is here to answer all your questions and provide you with the best possible service!',
            'text_cy' => 'Наш тим је ту да одговори на сва ваша питања и обезбеди вам најбољу могућу услугу!',
        ]);
    }
}
