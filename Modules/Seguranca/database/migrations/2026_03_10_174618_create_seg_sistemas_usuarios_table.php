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
          Schema::create('seg_sistemas_usuarios', function (Blueprint $table) {

            $table->unsignedBigInteger('usr_id');
            $table->unsignedBigInteger('sis_id');

            $table->primary(['usr_id', 'sis_id']);

            $table->foreign('usr_id')
                    ->references('usr_id')
                    ->on('seg_usuarios')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

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
        Schema::dropIfExists('seg_sistemas_usuarios');
    }
};
