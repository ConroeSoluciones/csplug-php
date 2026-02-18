<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

final class PaginatedResponse
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        public array $data,
        public int $currentPage,
        public int $total
    ) {
    }
}
