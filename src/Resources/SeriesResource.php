<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Serie;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Global Series Resource (/series)
 */
final class SeriesResource extends BaseResource
{
    use ResponseHandlerTrait;

    /**
     * @throws TransportExceptionInterface
     * @throws \Throwable
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $path = '/series';
        $queryParams = $options?->getQuery() ?? [];

        $request = $this->requestFactory->createRequest(
            uri: $path, 
            queryParams: $queryParams,
            options: $options
        );
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        
        $items = array_map(
            fn($item) => Serie::fromArray($item), 
            $body['data'] ?? []
        );

        return new PaginatedResponse(
            $items,
            (int) ($body['current_page'] ?? 1),
            (int) ($body['total'] ?? count($items))
        );
    }

    public function create(Serie $serie, ?RequestOptions $options = null): Serie
    {
        $request = $this->requestFactory->createRequest(
            uri: '/series',
            body: $serie,
            method: \Csfacturacion\CsPlug\Model\HttpMethod::POST,
            options: $options
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? $body;
        
        return Serie::fromArray($data);
    }
}
