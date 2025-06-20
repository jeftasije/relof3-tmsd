<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        Employee::create([
            'name' => 'Dragica Nikolić',
            'position' => 'Diplomirani bibliotekar',
            'position_en' => 'Graduate Librarian',
            'position_cy' => 'Дипломирани библиотекар',
            'biography' => 'Dragica je strastvena bibliotekarka sa 5 godina iskustva u radu sa mlađim čitaocima i digitalizacijom fonda.',
            'biography_en' => 'Dragica is a passionate librarian with 5 years of experience working with young readers and digitizing the collection.',
            'biography_cy' => 'Драгица је страствена библиотекарка са 5 година искуства у раду са млађим читаоцима и дигитализацијом фонда.',
            'image_path' => 'images/dragica.jpeg',
        ]);

        Employee::create([
            'name' => 'Marko Petrović',
            'position' => 'Administrator biblioteke',
            'position_en' => 'Library Administrator',
            'position_cy' => 'Администратор библиотеке',
            'biography' => 'Marko se brine o tehničkoj opremi i informacionim sistemima biblioteke, sa fokusom na pristup elektronskim izvorima.',
            'biography_en' => 'Marko manages the library’s technical equipment and information systems, with a focus on access to electronic resources.',
            'biography_cy' => 'Марко се брине о техничкој опреми и информационим системима библиотеке, са фокусом на приступ електронским изворима.',
            'image_path' => 'images/marko.jpeg',
        ]);

        Employee::create([
            'name' => 'Jelena Simić',
            'position' => 'Pomoćnik bibliotekara',
            'position_en' => 'Library Assistant',
            'position_cy' => 'Помоћник библиотекара',
            'biography' => 'Jelena pomaže u obradi i izdavanju knjiga, kao i u organizaciji kulturnih događaja i radionica za decu.',
            'biography_en' => 'Jelena assists in book processing and lending, as well as organizing cultural events and workshops for children.',
            'biography_cy' => 'Јелена помаже у обради и издавању књига, као и у организацији културних догађаја и радионица за децу.',
            'image_path' => 'images/jelena.jpg',
        ]);

        Employee::create([
            'name' => 'Nemanja Ristić',
            'position' => 'Specijalista za arhivu',
            'position_en' => 'Archive Specialist',
            'position_cy' => 'Специјалиста за архиву',
            'biography' => 'Nemanja vodi računa o čuvanju stare i retke građe, kao i o digitalnoj arhivi biblioteke.',
            'biography_en' => 'Nemanja is responsible for preserving rare and old materials, as well as maintaining the digital archive of the library.',
            'biography_cy' => 'Немања води рачуна о чувању старе и ретке грађе, као и о дигиталној архиви библиотеке.',
            'image_path' => 'images/nemanja.jpg',
        ]);
    }
}