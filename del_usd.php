<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Moneda;

$usd = Moneda::where('estandar_iso', 'USD')->first();
if ($usd) {
    $usd->delete();
    echo "OK: Dólar eliminado de la lista de monedas.\n";
} else {
    echo "El Dólar no estaba registrado.\n";
}
