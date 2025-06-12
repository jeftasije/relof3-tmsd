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
            'biography' => 'Dragica je strastvena bibliotekarka sa 5 godina iskustva u radu sa mlađim čitaocima i digitalizacijom fonda.',
            'image_path' => 'images/dragica.jpeg',
        ]);

        Employee::create([
            'name' => 'Marko Petrović',
            'position' => 'Administrator biblioteke',
            'biography' => 'Marko se brine o tehničkoj opremi i informacionim sistemima biblioteke, sa fokusom na pristup elektronskim izvorima.',
            'image_path' => 'images/marko.jpeg',
        ]);

        Employee::create([
            'name' => 'Jelena Simić',
            'position' => 'Pomoćnik bibliotekara',
            'biography' => 'Jelena pomaže u obradi i izdavanju knjiga, kao i u organizaciji kulturnih događaja i radionica za decu.',
            'image_path' => 'images/jelena.jpg',
        ]);

        Employee::create([
            'name' => 'Nemanja Ristić',
            'position' => 'Specijalista za arhivu',
            'biography' => 'Nemanja vodi računa o čuvanju stare i retke građe, kao i o digitalnoj arhivi biblioteke.',
            'image_path' => 'images/nemanja.jpg',
        ]);
    }
}
