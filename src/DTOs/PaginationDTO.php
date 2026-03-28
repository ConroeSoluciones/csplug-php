<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs;

use function filter_var;
use function is_int;
use function is_string;

use const FILTER_VALIDATE_INT;

/**
 * Immutable Pagination DTO with strict typing.
 */
final readonly class PaginationDTO
{
    public function __construct(
        public int $currentPage = 1,
        public int $perPage = 15,
        public int $total = 0,
        public int $lastPage = 1,
        public ?string $nextPageUrl = null,
        public ?string $prevPageUrl = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        /** @var int|string $currentPage */
        $currentPage = $data['current_page'] ?? 1;
        /** @var int|string $perPage */
        $perPage = $data['per_page'] ?? 15;
        /** @var int|string $total */
        $total = $data['total'] ?? 0;
        /** @var int|string $lastPage */
        $lastPage = $data['last_page'] ?? 1;

        $nextPageUrl = isset($data['next_page_url']) && is_string($data['next_page_url'])
            ? $data['next_page_url']
            : null;
        $prevPageUrl = isset($data['prev_page_url']) && is_string($data['prev_page_url'])
            ? $data['prev_page_url']
            : null;

        return new self(
            currentPage: self::toInt($currentPage, 1),
            perPage: self::toInt($perPage, 15),
            total: self::toInt($total, 0),
            lastPage: self::toInt($lastPage, 1),
            nextPageUrl: $nextPageUrl,
            prevPageUrl: $prevPageUrl,
        );
    }

    private static function toInt(int | string $value, int $default): int
    {
        if (is_int($value)) {
            return $value;
        }

        $filtered = filter_var($value, FILTER_VALIDATE_INT);

        return $filtered !== false ? $filtered : $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'last_page' => $this->lastPage,
            'next_page_url' => $this->nextPageUrl,
            'prev_page_url' => $this->prevPageUrl,
        ];
    }
}
