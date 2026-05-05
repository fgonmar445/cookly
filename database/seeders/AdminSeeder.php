<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cookly.com'],
            [
                'name' => 'Admin Cookly',
                'password' => Hash::make('admin123'),
                'rol' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@cookly.com'],
            [
                'name' => 'Usuario Normal',
                'password' => Hash::make('user123'),
                'rol' => 'user',
            ]
        );
    }
}
