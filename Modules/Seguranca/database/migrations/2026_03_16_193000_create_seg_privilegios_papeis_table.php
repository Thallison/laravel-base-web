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
        Schema::create('seg_privilegios_papeis', function (Blueprint $table) {
            $table->unsignedBigInteger('priv_id');
            $table->unsignedBigInteger('papel_id');

            $table->primary(['priv_id', 'papel_id']);

            $table->foreign('priv_id')
                    ->references('priv_id')
                    ->on('seg_privilegios')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');

            $table->foreign('papel_id')
                  ->references('papel_id')
                  ->on('seg_papeis')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seg_privilegios_papeis');
    }
};
