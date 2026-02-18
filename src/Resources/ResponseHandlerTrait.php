<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Error\ExceptionFactory;
use Csfacturacion\CsPlug\Model\HttpResponse;

trait ResponseHandlerTrait
{
    protected function handleResponse(HttpResponse $response): void
    {
        if ($response->isSuccess()) {
            return;
        }

        throw ExceptionFactory::createFromResponse($response);
    }
}
