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
    public function list(int $page = 1, ?RequestOptions $options = null): PaginatedResponse
    {
        $path = sprintf('/series?page=%d', $page);
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
