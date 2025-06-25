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
            'name_en' => 'Dragica Nikolic',
            'name_cy' => 'Драгица Николић',
            'position' => 'Direktor biblioteke',
            'position_en' => 'Library Director',
            'position_cy' => 'Директор библиотеке',
            'biography' => 'Dragica vodi biblioteku sa vizijom modernizacije i unapređenja usluga.',
            'biography_en' => 'Dragica leads the library with a vision of modernization and improved services.',
            'biography_cy' => 'Драгица води библиотеку са визијом модернизације и унапређења услуга.',
            'image_path' => 'images/dragica.jpeg',
        ]);

        Employee::create([
            'name' => 'Marko Petrović',
            'name_en' => 'Marko Petrovic',
            'name_cy' => 'Марко Петровић',
            'position' => 'Član upravnog odbora',
            'position_en' => 'Board Member',
            'position_cy' => 'Члан управног одбора',
            'biography' => 'Marko učestvuje u donošenju strateških odluka i razvoju biblioteke.',
            'biography_en' => 'Marko participates in strategic decisions and library development.',
            'biography_cy' => 'Марко учествује у доношењу стратешких одлука и развоју библиотеке.',
            'image_path' => 'images/marko.jpeg',
        ]);

        Employee::create([
            'name' => 'Jelena Simić',
            'name_en' => 'Jelena Simic',
            'name_cy' => 'Јелена Симић',
            'position' => 'Glavni bibliotekar',
            'position_en' => 'Head Librarian',
            'position_cy' => 'Главни библиотекар',
            'biography' => 'Jelena je odgovorna za rad sa fondom i korisnicima biblioteke.',
            'biography_en' => 'Jelena is responsible for managing the collection and assisting library users.',
            'biography_cy' => 'Јелена је одговорна за рад са фондом и корисницима библиотеке.',
            'image_path' => 'images/jelena.jpg',
        ]);

        Employee::create([
            'name' => 'Nemanja Ristić',
            'name_en' => 'Nemanja Ristic',
            'name_cy' => 'Немања Ристић',
            'position' => 'Referent za pozajmicu',
            'position_en' => 'Circulation Desk Officer',
            'position_cy' => 'Референт за позајмицу',
            'biography' => 'Nemanja pomaže korisnicima pri izdavanju i vraćanju knjiga.',
            'biography_en' => 'Nemanja assists users with borrowing and returning books.',
            'biography_cy' => 'Немања помаже корисницима при издавању и враћању књига.',
            'image_path' => 'images/nemanja.jpg',
        ]);
    }
}
