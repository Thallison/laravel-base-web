<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('seg_modulos')->insert([
            'mod_id' => 1,
            'sis_id' => 1,
            'mod_nome' => 'Acesso',
            'mod_icone' => 'fa-solid fa-wrench',
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
