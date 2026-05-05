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
        // Renombrar la tabla
        Schema::rename('activity_logs', 'actividad');

        // Renombrar las columnas
        Schema::table('actividad', function (Blueprint $table) {
            $table->renameColumn('action', 'accion');
            $table->renameColumn('description', 'descripcion');
            $table->renameColumn('admin_id', 'id_admin');
            $table->renameColumn('created_at', 'fecha_creacion');
            $table->renameColumn('updated_at', 'fecha_actualizacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividad', function (Blueprint $table) {
            $table->renameColumn('accion', 'action');
            $table->renameColumn('descripcion', 'description');
            $table->renameColumn('id_admin', 'admin_id');
            $table->renameColumn('fecha_creacion', 'created_at');
            $table->renameColumn('fecha_actualizacion', 'updated_at');
        });

        Schema::rename('actividad', 'activity_logs');
    }
};
