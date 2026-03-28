<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Contracts;

use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\RequestOptions;
use JsonSerializable;

interface RequestFactory
{
    /**
     * Create a new HTTP request.
     *
     * @param array<string, string> $queryParams
     * @param JsonSerializable|array<string, mixed>|null $body
     */
    public function createRequest(
        string $uri,
        array $queryParams = [],
        JsonSerializable | array | null $body = null,
        HttpMethod $method = HttpMethod::GET,
        ?RequestOptions $options = null,
    ): HttpRequest;
}
