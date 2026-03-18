<?php

namespace Modules\Seguranca\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegSistemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seg_sistemas')->insert([
            'sis_id' => 1,
            'sis_nome' => 'Base',
            'sis_icone' => null,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}