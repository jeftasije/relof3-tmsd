<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navigation;

class NavigationSeeder extends Seeder
{
    public function run()
    {
        $oNama = Navigation::create([
            'name' => 'O nama',
            'name_en' => 'About us',
            'name_cy' => 'О нама',
            'is_deletable' => false,
            'order' => 1,
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Vesti',
            'name_en' => 'News',
            'name_cy' => 'Вести',
            'is_deletable' => false,
            'redirect_url' => '/vesti',
            'order' => 2,
            'is_active' => 1
        ]);
        $dokumenta = Navigation::create([
            'name' => 'Dokumenta',
            'name_en' => 'Documents',
            'name_cy' => 'Документа',
            'is_deletable' => false,
            'redirect_url' => '/dokumenti',
            'order' => 3,
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Usluge',
            'name_en' => 'Services',
            'name_cy' => 'Услуге',
            'is_deletable' => false,
            'redirect_url' => '/usluge',
            'order' => 4,
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Javne nabavke',
            'name_en' => 'Public procurement',
            'name_cy' => 'Јавне набавке',
            'is_deletable' => false,
            'redirect_url' => '/nabavke',
            'order' => 5,
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Žalbe',
            'name_en' => 'Complaints',
            'name_cy' => 'Жалбе',
            'is_deletable' => false,
            'redirect_url' => '/zalbe',
            'order' => 6,
            'is_active' => 1
        ]);
        $kontakt = Navigation::create([
            'name' => 'Kontakt',
            'name_en' => 'Contact',
            'name_cy' => 'Контакт',
            'is_deletable' => false,
            'redirect_url' => '/kontakt',
            'order' => 7,
            'is_active' => 1
        ]);
        $kontaktSub = Navigation::create([
            'name' => 'Kontakt',
            'name_en' => 'Contact',
            'name_cy' => 'Контакт',
            'is_deletable' => false,
            'parent_id' => $kontakt->id,
            'redirect_url' => '/kontakt',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Kontakt',
            'name_en' => 'Contact',
            'name_cy' => 'Контакт',
            'is_deletable' => false,
            'parent_id' => $kontaktSub->id,
            'redirect_url' => '/kontakt',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Blog',
            'name_en' => 'Blog',
            'name_cy' => 'Блог',
            'is_deletable' => false,
            'parent_id' => $kontaktSub->id,
            'redirect_url' => '/blog',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Česta pitanja',
            'name_en' => 'FAQ',
            'name_cy' => 'Честа питања',
            'is_deletable' => false,
            'parent_id' => $kontaktSub->id,
            'redirect_url' => '/pitanja',
            'is_active' => 1
        ]);
        $pravnaDokumentacija = Navigation::create([
            'name' => 'Poslovodstvo',
            'name_en' => 'Management',
            'name_cy' => 'Пословодство',
            'parent_id' => $dokumenta->id,
            'is_deletable' => false,
            'is_active' => 1
        ]);
        $planoviIIzveštaji = Navigation::create([
            'name' => 'O radu',
            'name_en' => 'Reports',
            'name_cy' => 'О раду',
            'parent_id' => $dokumenta->id,
            'is_deletable' => false,
            'is_active' => 1
        ]);
        $informacijeORaduIProcedurama = Navigation::create([
            'name' => 'Informacije o radu i procedurama',
            'name_en' => 'Work info and procedures',
            'name_cy' => 'Информације о раду и процедурама',
            'parent_id' => $dokumenta->id,
            'is_deletable' => false,
            'is_active' => 1
        ]);

        Navigation::create([
            'name' => 'Statut',
            'name_en' => 'Statute',
            'name_cy' => 'Статут',
            'parent_id' => $pravnaDokumentacija->id,
            'is_deletable' => false,
            'redirect_url' => '/dokumenti?category=Statut',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Osnivački akti',
            'name_en' => 'Founding acts',
            'name_cy' => 'Оснивачки акти',
            'parent_id' => $pravnaDokumentacija->id,
            'is_deletable' => false,
            'redirect_url' => '/dokumenti?category=Osnivački akti',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Druga akta koja regulišu oblasti etike i integriteta',
            'name_en' => 'Other acts regulating ethics and integrity',
            'name_cy' => 'Друга акта која регулишу области етике и интегритета',
            'parent_id' => $pravnaDokumentacija->id,
            'is_deletable' => false,
            'redirect_url' => '/dokumenti?category=Druga akta koja regulišu oblasti etike i integriteta',
            'is_active' => 1
        ]);

        Navigation::create([
            'name' => 'Godišnji planovi',
            'name_en' => 'Annual plans',
            'name_cy' => 'Годишњи планови',
            'parent_id' => $planoviIIzveštaji->id,
            'is_deletable' => false,
            'redirect_url' => '/dokumenti?category=Godišnji planovi',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Izveštaji o radu',
            'name_en' => 'Activity reports',
            'name_cy' => 'Извештаји о раду',
            'parent_id' => $planoviIIzveštaji->id,
            'is_deletable' => false,
            'redirect_url' => '/dokumenti?category=Izveštaji o radu',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Izveštaji o radu organa upravljanja',
            'name_en' => 'Management body reports',
            'name_cy' => 'Извештаји о раду органа управљања',
            'parent_id' => $planoviIIzveštaji->id,
            'is_deletable' => false,
            'redirect_url' => '/dokumenti?category=Izveštaji o radu organa upravljanja',
            'is_active' => 1
        ]);

        Navigation::create([
            'name' => 'Informator o radu',
            'name_en' => 'Information book',
            'name_cy' => 'Информатор о раду',
            'parent_id' => $informacijeORaduIProcedurama->id,
            'is_deletable' => false,
            'redirect_url' => 'https://informator.poverenik.rs/informator?org=evvj4rSTdRPuDbbdT',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Procedura o izboru direktora',
            'name_en' => 'Director election procedure',
            'name_cy' => 'Процедура о избору директора',
            'parent_id' => $informacijeORaduIProcedurama->id,
            'is_deletable' => false,
            'redirect_url' => '/dokumenti?category=Procedura o izboru direktora',
            'is_active' => 1
        ]);
        $organizacija = Navigation::create([
            'name' => 'Organizacija',
            'name_en' => 'Organization',
            'name_cy' => 'Организација',
            'parent_id' => $oNama->id,
            'is_deletable' => false,
            'is_active' => 1
        ]);
        $oBiblioteci = Navigation::create([
            'name' => 'O bibioteci',
            'name_en' => 'About library',
            'name_cy' => 'О библотеци',
            'parent_id' => $oNama->id,
            'is_deletable' => false,
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Istorijat',
            'name_en' => 'History',
            'name_cy' => 'Историјат',
            'parent_id' => $oBiblioteci->id,
            'is_deletable' => false,
            'redirect_url' => '/istorijat',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Galerija',
            'name_en' => 'Gallery',
            'name_cy' => 'Галерија',
            'parent_id' => $oBiblioteci->id,
            'is_deletable' => false,
            'redirect_url' => '/galerija',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Organizaciona struktura',
            'name_en' => 'Organizational structure',
            'name_cy' => 'Организациона структура',
            'parent_id' => $organizacija->id,
            'is_deletable' => false,
            'redirect_url' => '/organizaciona-struktura',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Zaposleni',
            'name_en' => 'Employees',
            'name_cy' => 'Запослени',
            'parent_id' => $organizacija->id,
            'is_deletable' => false,
            'redirect_url' => '/zaposleni',
            'is_active' => 1
        ]);
        Navigation::create([
            'name' => 'Sistematizacija radnih mesta',
            'name_en' => 'Job classification',
            'name_cy' => 'Систематизација радних места',
            'parent_id' => $organizacija->id,
            'is_deletable' => false,
            'redirect_url' => '/storage/documents/Sistematizacija-2025.pdf',
            'is_active' => 1
        ]);
    }
}
