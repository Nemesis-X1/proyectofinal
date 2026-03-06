<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Compra;

$compras = Compra::all();
echo "ID | Comprobante Path | Archivo Existe\n";
echo "---|-------------------|----------------\n";
foreach ($compras as $compra) {
    $exists = $compra->comprobante_path && file_exists(public_path($compra->comprobante_path)) ? 'SÍ' : 'NO';
    echo "{$compra->id} | {$compra->comprobante_path} | {$exists}\n";
}
