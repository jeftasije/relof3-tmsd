<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reminder;
use Carbon\Carbon;

class ReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reminder::create([
        'title_en' => 'Reminder about public procurements',
        'title_cyr' => 'Подсетник о јавним набавкама',
        'title_lat' => 'Podsetnik o javnim nabavkama',
        'time' => Carbon::create(2025, 7, 25, 14, 30, 0), // 25th june 2025 14:30
        ]);

        Reminder::create([
            'title_en' => 'Reminder about the annual work plan',
            'title_cyr' => 'Подсетник о годишњем плану рада',
            'title_lat' => 'Podsetnik o godišnjem planu rada',
            'time' => Carbon::create(2025, 8, 25, 14, 30, 0), 
        ]);
    }
}
