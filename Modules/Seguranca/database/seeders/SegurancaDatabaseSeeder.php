<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;

class SegurancaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $this->call([
            //SegUsuarioSeeder::class,
            //SegSistemasSeeder::class,
            //SegModulosSeeder::class,
            //SegFuncionalidadesSeeder::class,
            //SegPrivilegiosSeeder::class,
            SegDependenciasPrivilegiosSeeder::class,
         ]);
    }
}
