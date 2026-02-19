<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Serie;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\CsPlug\Model\HttpMethod;

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

    public function create(string $rfc, Serie $serie, ?RequestOptions $options = null): Serie
    {
        $path = sprintf('/emisores-hijos/%s/series', $rfc);
        
        $request = $this->requestFactory->createRequest(
            uri: $path,
            body: $serie,
            method: HttpMethod::POST,
            options: $options
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? $body;
        
        return Serie::fromArray($data);
    }
}
