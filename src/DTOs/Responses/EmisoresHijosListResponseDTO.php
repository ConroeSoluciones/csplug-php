<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\DTOs\PaginationDTO;
use InvalidArgumentException;

use function array_map;
use function is_array;
use function is_string;

/**
 * Response DTO for EmisorHijo list endpoint.
 */
final readonly class EmisoresHijosListResponseDTO
{
    /**
     * @param array<int, EmisorHijoResponseDTO> $items
     */
    public function __construct(
        public array $items,
        public string $message,
        public PaginationDTO $pagination,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['data']) || !is_array($data['data'])) {
            throw new InvalidArgumentException('Response must contain data array');
        }

        $items = [];
        /** @var array<array-key, mixed> $dataItems */
        $dataItems = $data['data'];
        foreach ($dataItems as $item) {
            if (!is_array($item)) {
                throw new InvalidArgumentException('Each item must be an array');
            }
            /** @var array<string, mixed> $itemArray */
            $itemArray = $item;
            $items[] = EmisorHijoResponseDTO::fromArray($itemArray);
        }

        /** @var array<string, mixed>|null $paginationData */
        $paginationData = isset($data['pagination']) && is_array($data['pagination']) ? $data['pagination'] : null;
        $pagination = $paginationData !== null
            ? PaginationDTO::fromArray($paginationData)
            : new PaginationDTO();

        /** @var mixed $messageValue */
        $messageValue = $data['message'] ?? 'Success';
        $message = is_string($messageValue) ? $messageValue : 'Success';

        return new self(
            items: $items,
            message: $message,
            pagination: $pagination,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'data' => array_map(
                static fn (EmisorHijoResponseDTO $item): array => $item->toArray(),
                $this->items,
            ),
            'pagination' => $this->pagination->toArray(),
        ];
    }
}
