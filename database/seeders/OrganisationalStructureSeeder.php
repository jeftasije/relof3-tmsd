<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrganisationalStructure;

class OrganisationalStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrganisationalStructure::create([
            'title' => 'ORG_SHEMA',
            'file_path' => 'organisationalStructures/ORG_SHEMA.pdf',
        ]);
    }
}
