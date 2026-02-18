<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

final class HttpRequest
{
    public function __construct(
        public string $method,
        public string $url,
        public array $options = []
    ) {
    }
}
