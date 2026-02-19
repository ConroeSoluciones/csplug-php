<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\EmisorHijo;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;


final class EmisoresHijosResource extends BaseResource
{
    use ResponseHandlerTrait;

    private const ENDPOINT = '/emisores-hijos';

    /**
     * @param RequestOptions|null $options
     * @return PaginatedResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws JsonException
     * @throws Throwable
     */
    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $request = $this->requestFactory->createRequest(
            uri: self::ENDPOINT,
            queryParams: $options?->getQuery() ?? [],
            options: $options
        );

        $response = $this->client->send($request);
        
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? [];

        $items = array_map(
            static fn(array $item): EmisorHijo => EmisorHijo::fromArray($item),
            $data
        );

        return new PaginatedResponse(
            $items,
            (int) ($body['current_page'] ?? 1),
            (int) ($body['total'] ?? count($items))
        );
    }

    /**
     * Creates a new EmisorHijo resource.
     * @param EmisorHijo $emisorHijo
     * @param RequestOptions|null $options
     * @return EmisorHijo
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws JsonException
     * @throws Throwable
     */
    public function create(EmisorHijo $emisorHijo, ?RequestOptions $options = null): EmisorHijo
    {
        $request = $this->requestFactory->createRequest(
            uri: self::ENDPOINT,
            body: $emisorHijo,
            method: HttpMethod::POST,
            options: $options
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? $body;
        return EmisorHijo::fromArray($data);
    }
}
