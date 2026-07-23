<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

enum Service : string
{
    case CSPLUG = 'CPG';
    case CSWEB = 'CWB20';
}
