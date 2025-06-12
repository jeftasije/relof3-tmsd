<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navigation;

class NavigationSeeder extends Seeder
{

    public function run()
    {
        // Glavne sekcije (neobrisive)
        $oNama = Navigation::create(['name' => 'O nama', 'is_deletable' => false]);
        Navigation::create(['name' => 'Vesti', 'is_deletable' => false]);
        $dokumenta = Navigation::create(['name' => 'Dokumenta', 'is_deletable' => false]);
        Navigation::create(['name' => 'Usluge', 'is_deletable' => false]);
        Navigation::create(['name' => 'Javne nabavke', 'is_deletable' => false]);
        Navigation::create(['name' => 'Žalbe', 'is_deletable' => false]);
        Navigation::create(['name' => 'Kontakt', 'is_deletable' => false]);

        // Podsekcije
        $poslovodstvo = Navigation::create(['name' => 'Poslovodstvo', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);
        $oRadu = Navigation::create(['name' => 'O radu', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Procedura o izboru direktora', 'parent_id' => $poslovodstvo->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Izveštaji o radu organa upravljanja', 'parent_id' => $poslovodstvo->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Program rada', 'parent_id' => $oRadu->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Izveštaj o radu', 'parent_id' => $oRadu->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Informator o radu', 'parent_id' => $oRadu->id, 'is_deletable' => true]);
        $organizacija = Navigation::create(['name' => 'Organizacija', 'parent_id' => $oNama->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Organizaciona struktura', 'parent_id' => $organizacija->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Zaposleni', 'parent_id' => $organizacija->id, 'is_deletable' => true]);
    }   
}
