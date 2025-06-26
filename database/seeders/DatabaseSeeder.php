<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('document_categories')->truncate();
        DB::table('documents')->truncate();
        DB::table('employees')->truncate();
        DB::table('extended_biographies')->truncate();
        DB::table('news')->truncate();
        DB::table('extended_news')->truncate();
        DB::table('navigations')->truncate();
        DB::table('procurements')->truncate();
        DB::table('organisational_structures')->truncate();
        DB::table('reminders')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            DocumentCategorySeeder::class,
            DocumentSeeder::class,
            EmployeeSeeder::class,
            ExtendedBiographySeeder::class,
            NewsSeeder::class,
            ExtendedNewsSeeder::class,
            NavigationSeeder::class,
            ProcurementSeeder::class,
            OrganisationalStructureSeeder::class,
            ReminderSeeder::class, 
        ]);

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
    }
}