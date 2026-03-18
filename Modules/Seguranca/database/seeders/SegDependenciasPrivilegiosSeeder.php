<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegDependenciasPrivilegiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seg_dependencias_privilegios')->insert([
        [
            'dep_priv_id' => 1,
            'priv_id' => 10, // Editar funcionalidades
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\FuncionalidadesController',
            'dep_priv_action' => 'update',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 2,
            'priv_id' => 2, // Cadastrar Sistemas
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\SistemasController',
            'dep_priv_action' => 'store',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 3,
            'priv_id' => 6, // Cadastrar Módulos
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\ModulosController',
            'dep_priv_action' => 'store',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 4,
            'priv_id' => 11, // Cadastrar Funcionalidades
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\FuncionalidadesController',
            'dep_priv_action' => 'store',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 5,
            'priv_id' => 4, // Editar Sistemas
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\SistemasController',
            'dep_priv_action' => 'update',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 6,
            'priv_id' => 8, // Editar Módulos
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\ModulosController',
            'dep_priv_action' => 'update',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 7,
            'priv_id' => 18, // Cadastrar Papeis
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\PapeisController',
            'dep_priv_action' => 'store',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 8,
            'priv_id' => 19, // Editar Papeis
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\PapeisController',
            'dep_priv_action' => 'update',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 9,
            'priv_id' => 16, // Editar Privilégio
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\PrivilegiosController',
            'dep_priv_action' => 'update',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 10,
            'priv_id' => 16, // Editar Privilégio
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\PrivilegiosController',
            'dep_priv_action' => 'destroyDep',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 11,
            'priv_id' => 22, // Cadastrar usuário
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\UsuariosController',
            'dep_priv_action' => 'store',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 12,
            'priv_id' => 22, // Cadastrar usuário
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\UsuariosController',
            'dep_priv_action' => 'validaLogin',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 13,
            'priv_id' => 24, // Editar usuário
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\UsuariosController',
            'dep_priv_action' => 'update',
            'created_at' => now(),
            'updated_at' => null,
        ],

        [
            'dep_priv_id' => 14,
            'priv_id' => 24, // Editar usuário
            'dep_priv_controller' => 'Modules\\Seguranca\\Http\\Controllers\\UsuariosController',
            'dep_priv_action' => 'validaLogin',
            'created_at' => now(),
            'updated_at' => null,
        ],

    ]);
    }
}
