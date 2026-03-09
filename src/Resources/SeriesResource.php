<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\CsPlug\Model\Serie;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

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

    /**
     * @throws TransportExceptionInterface
     * @throws Throwable
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $path = '/series';
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

    public function create(Serie $serie, ?RequestOptions $options = null): Serie
    {
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

        return Serie::fromArray($data);
    }
}
