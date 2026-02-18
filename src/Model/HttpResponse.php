<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

final class HttpResponse
{
    public function __construct(
        public int $statusCode,
        public string $body,
        public array $headers = []
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return json_decode($this->body, true, 512, JSON_THROW_ON_ERROR);
    }
}
