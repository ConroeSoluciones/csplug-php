<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Cfdi;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PeticionCancelacion;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

final class CfdiResource extends BaseResource
{
    use ResponseHandlerTrait;

    private const ENDPOINT = '/cfdi';

    /**
     * @param array<string, mixed> $comprobante
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Throwable
 */
    public function timbrar(array $comprobante, ?RequestOptions $options = null): Cfdi
    {
        $request = $this->requestFactory->createRequest(
            uri: self::ENDPOINT,
            body: $comprobante,
            method: HttpMethod::POST,
            options: $options,
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $data */
        $data = $body['data'] ?? $body;

        /** @psalm-suppress MixedArgument */
        return Cfdi::fromTimbre($data); // @phpstan-ignore argument.type
    }

    /**
     * @param array<string, mixed> $comprobante
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Throwable
     * @throws TransportExceptionInterface
     */
    public function demo(array $comprobante, ?RequestOptions $options = null): Cfdi
    {
        $request = $this->requestFactory->createRequest(
            uri: '/demo' . self::ENDPOINT,
            body: $comprobante,
            method: HttpMethod::POST,
            options: $options,
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $data */
        $data = $body['data'] ?? $body;

        /** @psalm-suppress MixedArgument */
        return Cfdi::fromTimbre($data); // @phpstan-ignore argument.type
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
            options: $options,
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $data */
        $data = $body['data'] ?? $body;

        /** @psalm-suppress MixedArgument */
        return Cfdi::fromTimbre($data); // @phpstan-ignore argument.type
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Throwable
     * @throws TransportExceptionInterface
     */
    public function cancel(
        PeticionCancelacion $peticionCancelacion,
        ?RequestOptions $options = null,
        bool $isDemo = false,
    ): mixed {
        $uri = $isDemo ? '/demo' . self::ENDPOINT . '/cancelar' : self::ENDPOINT . '/cancelar';
        $request = $this->requestFactory->createRequest(
            uri: $uri,
            body: $peticionCancelacion,
            method: HttpMethod::POST,
            options: $options,
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        return $body['data'] ?? $body;
    }

    /**
     * @param string[] $emails
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Throwable
     * @throws TransportExceptionInterface
     */
    public function resend(string $uuid, array $emails, ?RequestOptions $options = null): mixed
    {
        $uri = self::ENDPOINT . "/{$uuid}}/send";
        $request = $this->requestFactory->createRequest(
            uri: $uri,
            body: [
                'email' => $emails,
            ],
            method: HttpMethod::POST,
            options: $options,
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        return $body['data'] ?? $body;
    }
}
