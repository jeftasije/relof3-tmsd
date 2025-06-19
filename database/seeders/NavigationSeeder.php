<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navigation;

class NavigationSeeder extends Seeder
{

    public function run()
    {
        $oNama = Navigation::create(['name' => 'O nama', 'is_deletable' => false, 'order'=>1]);
        Navigation::create(['name' => 'Vesti', 'is_deletable' => false, 'redirect_url' => '/news', 'order'=>2]);
        $dokumenta = Navigation::create(['name' => 'Dokumenta', 'is_deletable' => false, 'order'=>3]);
        Navigation::create(['name' => 'Usluge', 'is_deletable' => false, 'redirect_url' => '/usluge', 'order'=>4]);
        Navigation::create(['name' => 'Javne nabavke', 'is_deletable' => false, 'redirect_url' => '/nabavke', 'order'=>5]);
        Navigation::create(['name' => 'Žalbe', 'is_deletable' => false, 'order'=>6]);
        Navigation::create(['name' => 'Kontakt', 'is_deletable' => false, 'redirect_url' => '/kontakt', 'order'=>7]);

        $pravnaDokumentacija = Navigation::create(['name' => 'Poslovodstvo', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);
        $planoviIIzveštaji = Navigation::create(['name' => 'O radu', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);
        $informacijeORaduIProcedurama = Navigation::create(['name' => 'Informacije o radu i procedurama', 'parent_id' => $dokumenta->id, 'is_deletable' => true]);

        Navigation::create(['name' => 'Statut', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Statut']);
        Navigation::create(['name' => 'Osnivački akti', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Osnivački akti']);
        Navigation::create(['name' => 'Druga akta koja regulišu oblasti etike i integriteta', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Druga akta koja regulišu oblasti etike i integriteta']);

        Navigation::create(['name' => 'Godišnji planovi', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Godišnji planovi']);
        Navigation::create(['name' => 'Izveštaji o radu', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Izveštaji o radu']);
        Navigation::create(['name' => 'Izveštaji o radu organa upravljanja', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Izveštaji o radu organa upravljanja']);

        Navigation::create(['name' => 'Informator o radu', 'parent_id' => $informacijeORaduIProcedurama->id, 'is_deletable' => true, 'redirect_url' => 'https://informator.poverenik.rs/informator?org=evvj4rSTdRPuDbbdT']);
        Navigation::create(['name' => 'Procedura o izboru direktora', 'parent_id' => $informacijeORaduIProcedurama->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Procedura o izboru direktora']);
        
        $organizacija = Navigation::create(['name' => 'Organizacija', 'parent_id' => $oNama->id, 'is_deletable' => true]);
        Navigation::create(['name' => 'Organizaciona struktura', 'parent_id' => $organizacija->id, 'is_deletable' => true, 'redirect_url' => '/organizaciona-struktura']);
        Navigation::create(['name' => 'Zaposleni', 'parent_id' => $organizacija->id, 'is_deletable' => true, 'redirect_url' => '/employees']);
        Navigation::create(['name' => 'Sistematizacija radnih mesta', 'parent_id' => $organizacija->id, 'is_deletable' => true, 'redirect_url' => '/storage/documents/Sistematizacija-2025.pdf']);
    }
}
