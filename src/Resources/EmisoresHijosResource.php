<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Error\ApiException;
use Csfacturacion\CsPlug\Model\EmisorHijo;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

use Csfacturacion\CsPlug\Model\EmisorHijoParams;

final class EmisoresHijosResource extends BaseResource
{
    use ResponseHandlerTrait;

    /**
     * @param int $page
     * @param RequestOptions|null $options
     * @return PaginatedResponse
     * @throws ApiException
     * @throws \JsonException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Throwable
     */
    public function list(int $page = 1, ?RequestOptions $options = null): PaginatedResponse
    {
        $path = sprintf('/emisores-hijos?page=%d', $page);
        $request = $this->requestFactory->createRequest(
            'GET', 
            $path,
            $options
        );

        $response = $this->client->send($request);
        
        $this->handleResponse($response);

        $body = $response->toArray();
        
        $items = array_map(
            fn($item) => EmisorHijo::fromJson(json_encode($item, JSON_THROW_ON_ERROR)), 
            $body['data'] ?? []
        );

        return new PaginatedResponse(
            $items,
            (int) ($body['current_page'] ?? 1),
            (int) ($body['total'] ?? count($items))
        );
    }

    /**
     * @param EmisorHijoParams $params
     * @param RequestOptions|null $options
     * @return EmisorHijo
     * @throws ApiException
     * @throws \JsonException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Throwable
     */
    public function create(EmisorHijoParams $params, ?RequestOptions $options = null): EmisorHijo
    {
        $path = '/emisores-hijos';
        $request = $this->requestFactory->createRequest(
            'POST',
            $path,
            $options,
            $params->toArray()
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->toArray();

        return EmisorHijo::fromJson(json_encode($body['data'] ?? $body, JSON_THROW_ON_ERROR));
    }
}
