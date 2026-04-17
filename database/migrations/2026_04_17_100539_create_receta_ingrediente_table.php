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
        Schema::create('receta_ingrediente', function (Blueprint $table) {

            $table->foreignId('id_receta')
                ->constrained('recetas', 'id_receta')
                ->onDelete('cascade');

            $table->foreignId('id_ingrediente')
                ->constrained('ingredientes', 'id_ingrediente')
                ->onDelete('cascade');

            $table->string('cantidad')->nullable();

            $table->primary(['id_receta', 'id_ingrediente']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('receta_ingrediente');
    }
};
