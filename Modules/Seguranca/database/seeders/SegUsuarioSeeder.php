<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SegUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seg_usuarios')->insert([
            'usr_login' => 'admin.gestor',
            'password' => Hash::make('123456'),
            'usr_name' => 'Administrador',
            'email' => 'admin@email.com',
            'usr_status' => true,
            'usr_dt_criacao' => now(),
            'usr_dt_alteracao' => null,
            'usr_dt_ultimo_acesso' => null,
        ]);
    }
}
