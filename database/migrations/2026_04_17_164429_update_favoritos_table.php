<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {

            // Eliminamos FK antigua si existe
            $table->dropForeign(['id_receta_api']);

            // Eliminamos columna antigua
            $table->dropColumn('id_receta_api');

            // Nueva columna correcta
            $table->string('id_receta')->after('id_usuario');

            // Nueva FK correcta
            $table->foreign('id_receta')
                ->references('id_receta')
                ->on('recetas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('favoritos', function (Blueprint $table) {
            $table->dropForeign(['id_receta']);
            $table->dropColumn('id_receta');

            $table->string('id_receta_api');

            $table->foreign('id_receta_api')
                ->references('id_receta_api')
                ->on('receta');
        });
    }
};
