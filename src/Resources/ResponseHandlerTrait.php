<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Error\ExceptionFactory;
use Csfacturacion\CsPlug\Model\HttpResponse;

// phpcs:ignore SlevomatCodingStandard.Classes.SuperfluousTraitNaming.SuperfluousSuffix
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
