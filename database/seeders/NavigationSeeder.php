<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navigation;

class NavigationSeeder extends Seeder
{
    public function run()
    {
        $oNama = Navigation::create(['name' => 'O nama', 'name_en' => 'About us', 'is_deletable' => false]);
        Navigation::create(['name' => 'Vesti', 'name_en' => 'News', 'is_deletable' => false, 'redirect_url' => '/news']);
        $dokumenta = Navigation::create(['name' => 'Dokumenta', 'name_en' => 'Documents', 'is_deletable' => false]);
        Navigation::create(['name' => 'Usluge', 'name_en' => 'Services', 'is_deletable' => false, 'redirect_url' => '/usluge']);
        Navigation::create(['name' => 'Javne nabavke', 'name_en' => 'Public procurement', 'is_deletable' => false, 'redirect_url' => '/nabavke']);
        Navigation::create(['name' => 'Žalbe', 'name_en' => 'Complaints', 'is_deletable' => false]);
        Navigation::create(['name' => 'Kontakt', 'name_en' => 'Contact', 'is_deletable' => false, 'redirect_url' => '/kontakt']);

        $pravnaDokumentacija = Navigation::create([
            'name' => 'Poslovodstvo',
            'name_en' => 'Management',
            'parent_id' => $dokumenta->id,
            'is_deletable' => true
        ]);
        $planoviIIzveštaji = Navigation::create([
            'name' => 'O radu',
            'name_en' => 'Reports',
            'parent_id' => $dokumenta->id,
            'is_deletable' => true
        ]);
        $informacijeORaduIProcedurama = Navigation::create([
            'name' => 'Informacije o radu i procedurama',
            'name_en' => 'Work info and procedures',
            'parent_id' => $dokumenta->id,
            'is_deletable' => true
        ]);

        Navigation::create(['name' => 'Statut', 'name_en' => 'Statute', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Statut']);
        Navigation::create(['name' => 'Osnivački akti', 'name_en' => 'Founding acts', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Osnivački akti']);
        Navigation::create(['name' => 'Druga akta koja regulišu oblasti etike i integriteta', 'name_en' => 'Other acts regulating ethics and integrity', 'parent_id' => $pravnaDokumentacija->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Druga akta koja regulišu oblasti etike i integriteta']);

        Navigation::create(['name' => 'Godišnji planovi', 'name_en' => 'Annual plans', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Godišnji planovi']);
        Navigation::create(['name' => 'Izveštaji o radu', 'name_en' => 'Activity reports', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Izveštaji o radu']);
        Navigation::create(['name' => 'Izveštaji o radu organa upravljanja', 'name_en' => 'Management body reports', 'parent_id' => $planoviIIzveštaji->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Izveštaji o radu organa upravljanja']);

        Navigation::create(['name' => 'Informator o radu', 'name_en' => 'Information book', 'parent_id' => $informacijeORaduIProcedurama->id, 'is_deletable' => true, 'redirect_url' => 'https://informator.poverenik.rs/informator?org=evvj4rSTdRPuDbbdT']);
        Navigation::create(['name' => 'Procedura o izboru direktora', 'name_en' => 'Director election procedure', 'parent_id' => $informacijeORaduIProcedurama->id, 'is_deletable' => true, 'redirect_url' => '/dokumenti?category=Procedura o izboru direktora']);
        
        $organizacija = Navigation::create([
            'name' => 'Organizacija',
            'name_en' => 'Organization',
            'parent_id' => $oNama->id,
            'is_deletable' => true
        ]);
        Navigation::create(['name' => 'Organizaciona struktura', 'name_en' => 'Organizational structure', 'parent_id' => $organizacija->id, 'is_deletable' => true, 'redirect_url' => '/organizaciona-struktura']);
        Navigation::create(['name' => 'Zaposleni', 'name_en' => 'Employees', 'parent_id' => $organizacija->id, 'is_deletable' => true, 'redirect_url' => '/employees']);
        Navigation::create(['name' => 'Sistematizacija radnih mesta', 'name_en' => 'Job classification', 'parent_id' => $organizacija->id, 'is_deletable' => true, 'redirect_url' => '/storage/documents/Sistematizacija-2025.pdf']);
    }
}