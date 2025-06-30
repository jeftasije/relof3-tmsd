<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\DocumentCategory;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DocumentCategory::all()->pluck('id', 'name');

        $documents = [
            ['title' => 'Statut organizacije', 'file_path' => 'documents/statut.pdf', 'category' => 'Statut'],
            ['title' => 'Odluka-o-izmenama-i-dopunama-Statuta-Biblioteke', 'file_path' => 'documents/Odluka-o-izmenama-i-dopunama-Statuta-Biblioteke.pdf', 'category' => 'Statut'],
            ['title' => 'Osnivački akt Narodne biblioteke "Dositej Obradović"', 'file_path' => 'documents/osnivacki_akti.pdf', 'category' => 'Osnivački akti'],
            ['title' => 'Godišnji plan rada 2025', 'file_path' => 'documents/godisnji_plan_2025.pdf', 'category' => 'Godišnji planovi'],
            ['title' => 'Godišnji plan rada 2024', 'file_path' => 'documents/godisnji_plan_2024.pdf', 'category' => 'Godišnji planovi'],
            ['title' => 'Godišnji plan rada 2023', 'file_path' => 'documents/godisnji_plan_2023.pdf', 'category' => 'Godišnji planovi'],
            ['title' => 'Izveštaj o radu za 2023 (latinica)', 'file_path' => 'documents/izvestaj_o_radu_2023_latinica.pdf', 'category' => 'Izveštaji o radu'],
            ['title' => 'Izveštaj o radu za 2023 (ćirilica)', 'file_path' => 'documents/izvestaj_o_radu_2023_ćirilica.pdf', 'category' => 'Izveštaji o radu'],
            ['title' => 'Poslovnik-o-radu-Upravnog-odbora', 'file_path' => 'documents/Poslovnik-o-radu-Upravnog-odbora.pdf', 'category' => 'Izveštaji o radu organa upravljanja'],
            ['title' => 'Informator o radu ustanove', 'file_path' => 'documents/informator_o_radu.pdf', 'category' => 'Informator o radu'],
            ['title' => 'Procedura izbora direktora', 'file_path' => 'documents/procedura_izbora_direktora.pdf', 'category' => 'Procedura o izboru direktora'],
            ['title' => 'Kodeks etike i integriteta', 'file_path' => 'documents/kodeks_etike.pdf', 'category' => 'Druga akta koja regulišu oblasti etike i integriteta'],
        ];

        foreach ($documents as $doc) {
            if (isset($categories[$doc['category']])) {
                Document::create([
                    'title' => $doc['title'],
                    'file_path' => $doc['file_path'],
                    'category_id' => $categories[$doc['category']],
                ]);
            }
        }
    }
}
