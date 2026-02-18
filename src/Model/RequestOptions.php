<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

final class RequestOptions
{
    /**
     * @param array<string, string> $headers
     * @param array<string, mixed> $query
     */
    public function __construct(
        private readonly ?string $xRfc = null,
        private readonly ?Service $xServicio = null,
        private readonly array $headers = [],
        private readonly array $query = [],
    ) {
    }

    public function getXRfc(): ?string
    {
        return $this->xRfc;
    }

    public function getXServicio(): ?Service
    {
        return $this->xServicio;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
