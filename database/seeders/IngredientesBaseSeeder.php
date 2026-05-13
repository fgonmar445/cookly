<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ingrediente;

class IngredientesBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredientes = [
            // Verduras y hortalizas
            ['nombre' => 'Cebolla', 'categoria' => 'Verduras y hortalizas', 'es_base' => true],
            ['nombre' => 'Ajo', 'categoria' => 'Verduras y hortalizas', 'es_base' => true],
            ['nombre' => 'Tomate', 'categoria' => 'Verduras y hortalizas', 'es_base' => true],
            ['nombre' => 'Pimiento', 'categoria' => 'Verduras y hortalizas', 'es_base' => true],
            ['nombre' => 'Zanahoria', 'categoria' => 'Verduras y hortalizas', 'es_base' => true],
            ['nombre' => 'Patata', 'categoria' => 'Verduras y hortalizas', 'es_base' => true],
            
            // Carnes
            ['nombre' => 'Pollo', 'categoria' => 'Carnes', 'es_base' => true],
            ['nombre' => 'Ternera', 'categoria' => 'Carnes', 'es_base' => true],
            ['nombre' => 'Cerdo', 'categoria' => 'Carnes', 'es_base' => true],
            ['nombre' => 'Cordero', 'categoria' => 'Carnes', 'es_base' => true],
            
            // Pescados y mariscos
            ['nombre' => 'Salmón', 'categoria' => 'Pescados y mariscos', 'es_base' => true],
            ['nombre' => 'Atún', 'categoria' => 'Pescados y mariscos', 'es_base' => true],
            ['nombre' => 'Gambas', 'categoria' => 'Pescados y mariscos', 'es_base' => true],
            ['nombre' => 'Merluza', 'categoria' => 'Pescados y mariscos', 'es_base' => true],
            
            // Lácteos y huevos
            ['nombre' => 'Huevo', 'categoria' => 'Lácteos y huevos', 'es_base' => true],
            ['nombre' => 'Leche', 'categoria' => 'Lácteos y huevos', 'es_base' => true],
            ['nombre' => 'Queso', 'categoria' => 'Lácteos y huevos', 'es_base' => true],
            ['nombre' => 'Mantequilla', 'categoria' => 'Lácteos y huevos', 'es_base' => true],
            ['nombre' => 'Nata', 'categoria' => 'Lácteos y huevos', 'es_base' => true],
            
            // Cereales y pasta
            ['nombre' => 'Arroz', 'categoria' => 'Cereales y pasta', 'es_base' => true],
            ['nombre' => 'Pasta', 'categoria' => 'Cereales y pasta', 'es_base' => true],
            ['nombre' => 'Harina', 'categoria' => 'Cereales y pasta', 'es_base' => true],
            ['nombre' => 'Pan', 'categoria' => 'Cereales y pasta', 'es_base' => true],
            
            // Aceites y condimentos
            ['nombre' => 'Aceite de oliva', 'categoria' => 'Aceites y condimentos', 'es_base' => true],
            ['nombre' => 'Sal', 'categoria' => 'Aceites y condimentos', 'es_base' => true],
            ['nombre' => 'Pimienta', 'categoria' => 'Aceites y condimentos', 'es_base' => true],
            ['nombre' => 'Azúcar', 'categoria' => 'Aceites y condimentos', 'es_base' => true],
            ['nombre' => 'Vinagre', 'categoria' => 'Aceites y condimentos', 'es_base' => true],
        ];

        foreach ($ingredientes as $ing) {
            Ingrediente::firstOrCreate(
                ['nombre' => $ing['nombre']],
                [
                    'categoria' => $ing['categoria'],
                    'es_base' => $ing['es_base'],
                ]
            );
        }
    }
}
