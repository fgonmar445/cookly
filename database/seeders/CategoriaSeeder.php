<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Carnes'],
            ['nombre' => 'Pescados'],
            ['nombre' => 'Verduras'],
            ['nombre' => 'Frutas'],
            ['nombre' => 'Lácteos'],
            ['nombre' => 'Cereales'],
            ['nombre' => 'Especias'],
            ['nombre' => 'Salsas'],
            ['nombre' => 'Legumbres'],
            ['nombre' => 'Otros'],
        ]);
    }
}
