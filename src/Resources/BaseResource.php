<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Util\HttpClient;
use Csfacturacion\CsPlug\Util\RequestFactory;
use Csfacturacion\CsPlug\Model\CsPlugConfig;

abstract class BaseResource
{
    public function __construct(
        protected HttpClient $client,
        protected RequestFactory $requestFactory,
        protected CsPlugConfig $config
    ) {
    }
}
