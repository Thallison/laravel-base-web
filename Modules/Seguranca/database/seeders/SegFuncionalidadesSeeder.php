<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegFuncionalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('seg_funcionalidades')->insert([
            [
                'func_id' => 1,
                'mod_id' => 1,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Seguranca\\Http\\Controllers\\SistemasController',
                'func_label' => 'Sistemas',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => null,
                'func_rota_padrao' => 'seguranca::sistemas.index',
            ],
            [
                'func_id' => 2,
                'mod_id' => 1,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Seguranca\\Http\\Controllers\\ModulosController',
                'func_label' => 'Modulos',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => null,
                'func_rota_padrao' => 'seguranca::modulos.index',
            ],
            [
                'func_id' => 3,
                'mod_id' => 1,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Seguranca\\Http\\Controllers\\FuncionalidadesController',
                'func_label' => 'Funcionalidades',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => null,
                'func_rota_padrao' => 'seguranca::funcionalidades.index',
            ],
            [
                'func_id' => 4,
                'mod_id' => 1,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Seguranca\\Http\\Controllers\\PrivilegiosController',
                'func_label' => 'Privilégios',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 0,
                'func_icon' => null,
                'func_rota_padrao' => null,
            ],
            [
                'func_id' => 5,
                'mod_id' => 1,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Seguranca\\Http\\Controllers\\PapeisController',
                'func_label' => 'Perfil Usuário',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => null,
                'func_rota_padrao' => 'seguranca::papeis.index',
            ],
            [
                'func_id' => 6,
                'mod_id' => 1,
                'func_id_pai' => null,
                'func_controller' => 'Modules\\Seguranca\\Http\\Controllers\\UsuariosController',
                'func_label' => 'Usuarios',
                'func_tipo' => 'Controller',
                'func_acesso_menu' => 1,
                'func_icon' => null,
                'func_rota_padrao' => 'seguranca::usuarios.index',
            ],
        ]);
    }
}
