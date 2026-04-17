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
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id('id_favorito');

            $table->foreignId('id_usuario')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('id_receta')
                ->constrained('recetas', 'id_receta')
                ->onDelete('cascade');

            $table->timestamp('fecha_guardado')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoritos');
    }
};
