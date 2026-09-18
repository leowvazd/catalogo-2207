<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed de DESENVOLVIMENTO: cria um admin com senha conhecida.
     * Em produção rode apenas: php artisan db:seed --class=ProductSeeder
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@lessenzza.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        $this->call(ProductSeeder::class);
    }
}
