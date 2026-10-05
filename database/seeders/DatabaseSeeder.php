<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun Admin Morela dengan Password
        User::updateOrCreate(
            ['email' => 'admin@morela.com'],
            [
                'name' => 'Admin Morela',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
