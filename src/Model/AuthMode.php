<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

enum AuthMode: string
{
    case BASIC = 'basic';
    case BEARER = 'bearer';
}
