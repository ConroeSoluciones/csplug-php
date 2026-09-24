<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\DTOs\PaginationDTO;
use Csfacturacion\CsPlug\Util\ArrayNormalizer;
use InvalidArgumentException;

use function array_map;
use function array_values;
use function is_array;

/**
 * Respuesta completa del listado paginado de CFDIs.
 */
final readonly class CfdiListResponseDTO
{
    /**
     * @param list<CfdiListItemDTO> $items
     */
    public function __construct(
        public array $items,
        public PaginationDTO $pagination,
    ) {
    }

    /**
     * @param array<mixed, mixed> $body
     */
    public static function fromArray(array $body): self
    {
        $data = $body['data'] ?? null;

        if (!is_array($data)) {
            throw new InvalidArgumentException('Invalid list response: missing or malformed "data" key');
        }

        $items = array_map(
            static fn (mixed $item): CfdiListItemDTO => CfdiListItemDTO::fromArray(
                is_array($item) ? $item : [],
            ),
            array_values($data),
        );

        $pagination = PaginationDTO::fromArray(
            ArrayNormalizer::toMap(
                $body['pagination'] ?? $body,
            ),
        );

        return new self(
            items: $items,
            pagination: $pagination,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'data' => array_map(
                static fn (CfdiListItemDTO $item): array => $item->toArray(),
                $this->items,
            ),
            'pagination' => $this->pagination->toArray(),
        ];
    }
}
