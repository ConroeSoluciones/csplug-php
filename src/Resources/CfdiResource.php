<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Cfdi;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

class CfdiResource extends BaseResource
{
    use ResponseHandlerTrait;
    private const ENDPOINT = '/cfdi';

    /**
     * @throws TransportExceptionInterface
     * @throws Throwable
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function timbrar(array $comprobante, ?RequestOptions $options = null): Cfdi
    {
        $request = $this->requestFactory->createRequest(
            uri: self::ENDPOINT,
            body: $comprobante,
            method: HttpMethod::POST,
            options: $options
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? $body;

        return Cfdi::fromTimbre($data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Throwable
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function demo(array $comprobante, ?RequestOptions $options = null): Cfdi
    {
        $request = $this->requestFactory->createRequest(
            uri: "/demo" . self::ENDPOINT,
            body: $comprobante,
            method: HttpMethod::POST,
            options: $options
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? $body;

        return Cfdi::fromTimbre($data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Throwable
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function show(string $uuid, ?RequestOptions $options = null): Cfdi
    {
        $request = $this->requestFactory->createRequest(
            uri: self::ENDPOINT . '/' . $uuid,
            options: $options
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? $body;

        return Cfdi::fromTimbre($data);
    }
}
