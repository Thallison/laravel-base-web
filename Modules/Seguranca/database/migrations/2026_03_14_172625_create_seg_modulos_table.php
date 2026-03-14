<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seg_modulos', function (Blueprint $table) {
            $table->id('mod_id');
            $table->unsignedBigInteger('sis_id');
             
            $table->string('mod_nome', 45)->unique();
            $table->string('mod_icone', 45)->nullable();
            $table->timestamps();

            $table->foreign('sis_id')
                    ->references('sis_id')
                    ->on('seg_sistemas')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seg_modulos');
    }
};
