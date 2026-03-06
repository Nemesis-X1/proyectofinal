<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$compras = App\Models\Compra::all();
foreach ($compras as $c) {
    echo "ID: {$c->id} | PATH: " . ($c->comprobante_path ?: 'EMPTY') . "\n";
}
