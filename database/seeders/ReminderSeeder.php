<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reminder;

class ReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reminder::create([
        'title' => 'Podsetnik o javnim nabavkama',
        'category_en' => 'procurements',
        'category_cyr' => 'јавне набавке',
        'category_lat' => 'javne nabavke',
        'custom_category' => null,
        ]);
    }
}
