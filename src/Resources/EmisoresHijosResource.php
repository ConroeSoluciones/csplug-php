<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Error\ApiException;
use Csfacturacion\CsPlug\Model\EmisorHijo;
use Csfacturacion\CsPlug\Model\EmisorHijoBuilder;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\ParametersBuilder;
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
     * @param RequestOptions $options
     * @return PaginatedResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \JsonException
     * @throws \Throwable
     */
    public function list(RequestOptions $options): PaginatedResponse
    {
        $parametersBuilder = (new ParametersBuilder()) -> withQueryParams($options->getQuery());
        $request = $this->requestFactory->createRequest(
            uri: "/emisores-hijos",
            params: $parametersBuilder -> build(),
            options: $options
        );

        $response = $this->client->send($request);
        
        $this->handleResponse($response);

        $items = $response->bodyAsModel(EmisorHijo::class);
        $body = $response->bodyAsArray();

        return new PaginatedResponse(
            $items,
            (int) ($body['current_page'] ?? 1),
            (int) ($body['total'] ?? count($items))
        );
    }

    /**
     * @param EmisorHijoBuilder $emisorHijoBuilder
     * @param RequestOptions|null $options
     * @return EmisorHijo
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \JsonException
     * @throws \Throwable
     */
    public function create(EmisorHijoBuilder $emisorHijoBuilder, ?RequestOptions $options = null): EmisorHijo
    {
        $parametersBuilder = (new ParametersBuilder()) -> withQueryParams($options->getQuery())->withEntity($emisorHijoBuilder->build());
        $request = $this->requestFactory->createRequest(
            uri: "/emisores-hijos",
            params: $parametersBuilder -> build(),
            method: HttpMethod::POST,
            options: $options
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);
        return $response->bodyAsModel(EmisorHijo::class);
    }
}
