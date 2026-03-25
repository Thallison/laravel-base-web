<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegPerfilPadraoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seg_papeis')->insert([
            'papel_id' => 1,
            'papel_nome' => 'Administrador',
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('seg_privilegios_papeis')->insert([

            // Sistemas
            [
                'priv_id' => 1,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 2,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 3,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 4,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Módulos
            [
                'priv_id' => 5,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 6,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,

            ],
            [
                'priv_id' => 7,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 8,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Funcionalidades
            [
                'priv_id' => 9,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 10,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 11,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 12,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Privilégios
            [
                'priv_id' => 13,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 14,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 15,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 16,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Papeis
            [
                'priv_id' => 17,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 18,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 19,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 20,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Usuários
            [
                'priv_id' => 21,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 22,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 23,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 24,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 25,
                'papel_id' => 1,
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);

        DB::table('seg_usuarios_papeis')->insert([
            'papel_id' => 1,
            'usr_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('seg_sistemas_usuarios')->insert([
            'usr_id' => 1,
            'sis_id' => 1
        ]);
    }
}
