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
        Schema::table('ingredientes', function (Blueprint $table) {
            $table->string('categoria')->nullable();
            $table->boolean('es_base')->default(false);
            $table->timestamps();

            $table->dropColumn('descripcion');
            $table->dropColumn('imagen');
            $table->dropColumn('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredientes', function (Blueprint $table) {
            $table->dropColumn('categoria');
            $table->dropColumn('es_base');
            $table->dropTimestamps();

            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('tipo', 100)->nullable();
        });
    }
};
