<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userInfo = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@exmaple.com',
                'password' => Hash::make('pass1234'),
                'role' => 'superAdmin'
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@exmaple.com',
                'password' => Hash::make('pass1234'),
                'role' => 'editor'
            ]
            ];

        foreach ($userInfo as $user) {
            User::create($user);
        }
    }
}
