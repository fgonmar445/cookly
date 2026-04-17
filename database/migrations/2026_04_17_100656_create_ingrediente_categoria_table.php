<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ingrediente_categoria', function (Blueprint $table) {
            $table->foreignId('id_ingrediente')
                ->constrained('ingredientes', 'id_ingrediente')
                ->onDelete('cascade');

            $table->foreignId('id_categoria')
                ->constrained('categorias', 'id_categoria')
                ->onDelete('cascade');

            $table->primary(['id_ingrediente', 'id_categoria']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingrediente_categoria');
    }
};
