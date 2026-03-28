<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\DTOs\Responses\PlantillaResponseDTO;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;

use function array_map;
use function count;
use function is_numeric;

final class PlantillasResource extends BaseResource
{
    use ResponseHandlerTrait;

    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $request = $this->requestFactory->createRequest(
            uri: '/plantillas',
            options: $options,
        );
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        /** @var list<PlantillaResponseDTO> $items */
        $items = array_map(
            /** @psalm-suppress MixedArgument */
            static fn (mixed $item): PlantillaResponseDTO => PlantillaResponseDTO::fromArray($item), // @phpstan-ignore argument.type
            (array) ($body['data'] ?? []),
        );

        /** @var array<string, mixed> $pagination */
        $pagination = $body['pagination'] ?? [];

        return new PaginatedResponse(
            $items,
            is_numeric($pagination['current_page'] ?? null)
                ? (int) $pagination['current_page']
                : 1,
            is_numeric($pagination['total'] ?? null)
                ? (int) $pagination['total']
                : count($items),
        );
    }
}
