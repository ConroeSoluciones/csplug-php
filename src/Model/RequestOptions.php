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
        public ?string $xRfc = null,
        public ?string $xServicio = null,
        public array $headers = [],
        public array $query = []
    ) {
    }
}
