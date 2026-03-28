<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\DTOs\Requests\SerieRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\SerieResponseDTO;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;

use function array_key_exists;
use function array_map;
use function count;
use function is_array;
use function is_numeric;

/**
 * Global Series Resource (/series)
 */
final class SeriesResource extends BaseResource
{
    use ResponseHandlerTrait;

    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $path = '/series';
        /** @var array<string, string> $queryParams */
        $queryParams = $options?->getQuery() ?? [];

        $request = $this->requestFactory->createRequest(
            uri: $path,
            queryParams: $queryParams,
            options: $options,
        );
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        /** @var list<SerieResponseDTO> $items */
        $items = array_map(
            /** @psalm-suppress MixedArgument */
            static fn (mixed $item): SerieResponseDTO => SerieResponseDTO::fromArray($item), // @phpstan-ignore argument.type
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

    public function create(
        SerieRequestDTO $serie,
        ?RequestOptions $options = null,
    ): SerieResponseDTO {
        $request = $this->requestFactory->createRequest(
            uri: '/series',
            body: $serie,
            method: HttpMethod::POST,
            options: $options,
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $rawData */
        $rawData = array_key_exists('data', $body) ? $body['data'] : $body;
        /** @var array<string, mixed> $data */
        $data = is_array($rawData) ? $rawData : [];

        return SerieResponseDTO::fromArray($data);
    }
}
