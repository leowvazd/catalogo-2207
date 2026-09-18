<?php

use Database\Seeders\AdminUserSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * A Railway roda as migrations a cada deploy, mas não roda seeders.
     * Ambos os seeders são idempotentes: não duplicam dados nem alteram
     * estoque ou senha de registros que já existem.
     */
    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => ProductSeeder::class, '--force' => true]);
        Artisan::call('db:seed', ['--class' => AdminUserSeeder::class, '--force' => true]);
    }

    public function down(): void
    {
        //
    }
};
