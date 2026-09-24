<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

/**
 * Estatus de un CFDI en el listado.
 */
enum CfdiEstatus: int
{
    case Vigente = 1;
    case Cancelada = 2;
    case EnProcesoCancelacion = 3;
    case NoCancelable = 4;
    case CancelacionRechazada = 6;
}
