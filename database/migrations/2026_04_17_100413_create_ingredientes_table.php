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
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id('id_ingrediente');
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('tipo', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredientes');
    }
};
