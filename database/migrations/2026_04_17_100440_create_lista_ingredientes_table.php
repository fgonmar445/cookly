<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lista_ingredientes', function (Blueprint $table) {
            $table->id('id_lista');

            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');

            $table->foreignId('id_ingrediente')
                ->constrained('ingredientes', 'id_ingrediente')
                ->onDelete('cascade');

            $table->timestamp('fecha_guardado')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lista_ingredientes');
    }
};
