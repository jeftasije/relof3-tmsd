<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navigation;

class NavigationSeeder extends Seeder
{

    public function run()
    {
        $oNama = Navigation::create(['name' => 'O nama', 'is_deletable' => false]);
        Navigation::create(['name' => 'Vesti', 'is_deletable' => false]);
        $dokumenta = Navigation::create(['name' => 'Dokumenta', 'is_deletable' => false]);
        Navigation::create(['name' => 'Usluge', 'is_deletable' => false]);
        Navigation::create(['name' => 'Javne nabavke', 'is_deletable' => false]);
        Navigation::create(['name' => 'Žalbe', 'is_deletable' => false]);
        Navigation::create(['name' => 'Kontakt', 'is_deletable' => false]);

        $pravnaDokumentacija = Navigation::create(['name' => 'Poslovodstvo', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);
        $planoviIIzveštaji = Navigation::create(['name' => 'O radu', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);
        $informacijeORaduIProcedurama = Navigation::create(['name' => 'Informacije o radu i procedurama', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);

        Navigation::create(['name' => 'Statut', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Osnivački akti', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Druga akta koja regulišu oblasti etike i integriteta', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true]);

        Navigation::create(['name' => 'Godišnji planovi', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Izveštaj o radu', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Izveštaji o radu organa upravljanja', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true]);

        Navigation::create(['name' => 'Informator o radu', 'parent_id' => $informacijeORaduIProcedurama->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Procedura o izboru direktora', 'parent_id' => $informacijeORaduIProcedurama->id, 'is_deletable' => true]);
        
        $organizacija = Navigation::create(['name' => 'Organizacija', 'parent_id' => $oNama->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Organizaciona struktura', 'parent_id' => $organizacija->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Zaposleni', 'parent_id' => $organizacija->id, 'is_deletable' => true]);
    }
}
