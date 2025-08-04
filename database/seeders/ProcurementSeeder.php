<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Procurement;

class ProcurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Procurement::create([
            'title' => '3.-izmena-i-dopuna-plana-javnih-nabavki-za-2023.pdf',
            'file_path' => 'procurements/3.-izmena-i-dopuna-plana-javnih-nabavki-za-2023.pdf',
        ]);

        Procurement::create([
            'title' => 'Izmenjena-verzija-plana-javnih-nabavki.pdf',
            'file_path' => 'procurements/Izmenjena-verzija-plana-javnih-nabavki.pdf',
        ]);

        Procurement::create([
            'title' => 'Plan-javnih-nabavki-2023.917.pdf',
            'file_path' => 'procurements/Plan-javnih-nabavki-2023.917.pdf',
        ]);

        Procurement::create([
            'title' => 'Pravilnik-o-javnim-nabavkama1.pdf',
            'file_path' => 'procurements/Pravilnik-o-javnim-nabavkama1.pdf',
        ]);
    }
}
