<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Ingrediente;

$map = config('ingredients.en_to_es');
$count = 0;
$skipped = 0;

foreach(Ingrediente::all() as $ing) {
    $enName = strtolower($ing->nombre);
    if(isset($map[$enName])) {
        $ing->nombre = $map[$enName];
        $ing->save();
        $count++;
    } else {
        $skipped++;
    }
}

echo "Updated $count ingredients. Skipped $skipped (not in map).\n";
