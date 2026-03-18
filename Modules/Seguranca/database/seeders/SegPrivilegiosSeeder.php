<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegPrivilegiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seg_privilegios')->insert([

            // Sistemas
            [
                'priv_id' => 1,
                'func_id' => 1,
                'priv_label' => 'Listar Sistemas',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 2,
                'func_id' => 1,
                'priv_label' => 'Cadastrar Sistemas',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 3,
                'func_id' => 1,
                'priv_label' => 'Excluir Sistema',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 4,
                'func_id' => 1,
                'priv_label' => 'Editar Sistemas',
                'priv_action' => 'show',
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Módulos
            [
                'priv_id' => 5,
                'func_id' => 2,
                'priv_label' => 'Listar modulos',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 6,
                'func_id' => 2,
                'priv_label' => 'Cadastrar Módulos',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,

            ],
            [
                'priv_id' => 7,
                'func_id' => 2,
                'priv_label' => 'Excluir Módulos',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 8,
                'func_id' => 2,
                'priv_label' => 'Editar Módulos',
                'priv_action' => 'show',
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Funcionalidades
            [
                'priv_id' => 9,
                'func_id' => 3,
                'priv_label' => 'Listar funcionalidades',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 10,
                'func_id' => 3,
                'priv_label' => 'Editar funcionalidades',
                'priv_action' => 'edit',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 11,
                'func_id' => 3,
                'priv_label' => 'Cadastrar Funcionalidades',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 12,
                'func_id' => 3,
                'priv_label' => 'Excluir Funcionalidades',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Privilégios
            [
                'priv_id' => 13,
                'func_id' => 4,
                'priv_label' => 'Listar Privilégio',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 14,
                'func_id' => 4,
                'priv_label' => 'Cadastrar Privilégio',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 15,
                'func_id' => 4,
                'priv_label' => 'Excluir Privilégio',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 16,
                'func_id' => 4,
                'priv_label' => 'Editar Privilégio',
                'priv_action' => 'show',
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Papeis
            [
                'priv_id' => 17,
                'func_id' => 5,
                'priv_label' => 'Listar Papeis',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 18,
                'func_id' => 5,
                'priv_label' => 'Cadastrar Papeis',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 19,
                'func_id' => 5,
                'priv_label' => 'Editar Papeis',
                'priv_action' => 'edit',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 20,
                'func_id' => 5,
                'priv_label' => 'Excluir papeis',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],

            // Usuários
            [
                'priv_id' => 21,
                'func_id' => 6,
                'priv_label' => 'Listar usuários',
                'priv_action' => 'index',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 22,
                'func_id' => 6,
                'priv_label' => 'Cadastrar usuário',
                'priv_action' => 'create',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 23,
                'func_id' => 6,
                'priv_label' => 'Excluir usuário',
                'priv_action' => 'destroy',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'priv_id' => 24,
                'func_id' => 6,
                'priv_label' => 'Editar usuário',
                'priv_action' => 'edit',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
}
