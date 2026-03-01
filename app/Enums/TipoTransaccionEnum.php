<?php

namespace App\Enums;

enum TipoTransaccionEnum: string
{
    case Compra = 'COMPRA';
    case Venta = 'VENTA';
    case AjustePositivo = 'AJUSTE_POSITIVO';
    case AjusteNegativo = 'AJUSTE_NEGATIVO';
    case Devolucion = 'DEVOLUCION';
    case Apertura = 'APERTURA';
}
