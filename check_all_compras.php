<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$compras = App\Models\Compra::all();
echo "Total compras: " . $compras->count() . "\n";
foreach ($compras as $c) {
    echo "ID: {$c->id} | User: {$c->user_id} | Path: " . ($c->comprobante_path ?: 'EMPTY') . "\n";
}
