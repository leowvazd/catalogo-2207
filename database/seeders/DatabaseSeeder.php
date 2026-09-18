<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin com senha conhecida apenas em desenvolvimento local.
        if (app()->environment('local')) {
            User::firstOrCreate(
                ['email' => 'admin@lessenzza.com'],
                ['name' => 'Admin', 'password' => bcrypt('password')]
            );
        }

        $this->call([
            ProductSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
