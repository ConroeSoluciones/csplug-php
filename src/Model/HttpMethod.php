<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

enum HttpMethod
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
}
