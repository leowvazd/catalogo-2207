<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Cria o administrador a partir de ADMIN_EMAIL / ADMIN_PASSWORD.
     * Não faz nada se as variáveis não existirem ou se o usuário já existir,
     * então nunca redefine a senha de uma conta em uso.
     */
    public function run(): void
    {
        $email = config('custom.initial_admin_email');
        $password = config('custom.initial_admin_password');

        if (! $email || ! $password) {
            return;
        }

        User::firstOrCreate(
            ['email' => $email],
            ['name' => 'Admin', 'password' => bcrypt($password)]
        );
    }
}
