<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Serie;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;

/**
 * Child Series Resource (/emisores-hijos/{rfc}/series)
 */
final class SeriesEmisorHijoResource extends BaseResource
{
    use ResponseHandlerTrait;

    public function list(string $rfc, int $page = 1, ?RequestOptions $options = null): PaginatedResponse
    {
        $path = sprintf('/emisores-hijos/%s/series?page=%d', $rfc, $page);
        $request = $this->requestFactory->createRequest('GET', $path, $options);
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->toArray();
        
        $items = array_map(
            fn($item) => Serie::fromJson(json_encode($item)), 
            $body['data'] ?? []
        );

        return new PaginatedResponse(
            $items,
            (int) ($body['current_page'] ?? 1),
            (int) ($body['total'] ?? count($items))
        );
    }
}
