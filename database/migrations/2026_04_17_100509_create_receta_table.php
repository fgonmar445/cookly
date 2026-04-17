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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id('id_receta');

            $table->string('id_receta_api', 50)->nullable()->unique();

            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('categoria', 100)->nullable();
            $table->string('area', 100)->nullable();
            $table->string('tags', 255)->nullable();
            $table->string('youtube', 255)->nullable();

            $table->enum('origen', ['api', 'usuario']);
            $table->foreignId('id_usuario')->nullable()->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receta');
    }
};
