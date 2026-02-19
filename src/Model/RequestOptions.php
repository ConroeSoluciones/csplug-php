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
        private readonly ?string $contractId = null,
        private readonly ?Service $xServicio = null,
        private readonly array $headers = [],
        private readonly ?array $query = null,
    ) {
    }

    public function getContractId(): ?string
    {
        return $this->contractId;
    }

    public function getXServicio(): ?Service
    {
        return $this->xServicio;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getQuery(): ?array
    {
        return $this->query ?? null;
    }

    public function addHeader(string $key, string $value): self
    {
        $newHeaders = $this->headers;
        $newHeaders[$key] = $value;

        return new self(
            contractId: $this->contractId,
            xServicio: $this->xServicio,
            headers: $newHeaders,
            query: $this->query,
        );
    }

    public function addQueryParam(string $key, mixed $value): self
    {
        $newQuery = $this->query ?? [];
        $newQuery[$key] = $value;

        return new self(
            contractId: $this->contractId,
            xServicio: $this->xServicio,
            headers: $this->headers,
            query: $newQuery,
        );
    }

    public static function fromArray(array $options): self
    {
        return new self(
            contractId: $options['contract_id'] ?? null,
            xServicio: isset($options['x_servicio']) ? Service::from($options['x_servicio']) : null,
            headers: $options['headers'] ?? [],
            query: $options['query'] ?? null,
        );
    }
}
