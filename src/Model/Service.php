<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

enum Service : string
{
    case CSPLUG = 'CSP';
    case CSWEB = 'CWB20';
}
