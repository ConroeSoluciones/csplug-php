<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\CsPlug\Model\Serie;

use function array_key_exists;
use function array_map;
use function count;
use function is_array;
use function is_numeric;
use function sprintf;

/**
 * Child Series Resource (/emisores-hijos/{rfc}/series)
 */
final class SeriesEmisorHijoResource extends BaseResource
{
    use ResponseHandlerTrait;

    public function list(string $rfc, ?RequestOptions $options = null): PaginatedResponse
    {
        $path = sprintf('/emisores-hijos/%s/series', $rfc);
        $queryParams = $options?->getQuery() ?? [];

        $request = $this->requestFactory->createRequest(
            uri: $path,
            queryParams: $queryParams,
            options: $options,
        );
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        /** @var list<Serie> $items */
        $items = array_map(
            /** @psalm-suppress MixedArgument */
            static fn (mixed $item): Serie => Serie::fromArray($item), // @phpstan-ignore argument.type
            (array) ($body['data'] ?? []),
        );

        return new PaginatedResponse(
            $items,
            isset($body['current_page']) && is_numeric($body['current_page'])
                ? (int) $body['current_page']
                : 1,
            isset($body['total']) && is_numeric($body['total'])
                ? (int) $body['total']
                : count($items),
        );
    }

    public function create(string $rfc, Serie $serie, ?RequestOptions $options = null): Serie
    {
        $path = sprintf('/emisores-hijos/%s/series', $rfc);

        $request = $this->requestFactory->createRequest(
            uri: $path,
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

        return Serie::fromArray($data);
    }
}
