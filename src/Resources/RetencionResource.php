<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\DTOs\Requests\RetencionCancelarRequestDTO;
use Csfacturacion\CsPlug\DTOs\Requests\RetencionTimbrarRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\RetencionResponseDTO;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\RequestOptions;

use function is_array;

final class RetencionResource extends BaseResource
{
    use ResponseHandlerTrait;

    private const string ENDPOINT = '/retenciones';

    public function timbrar(
        RetencionTimbrarRequestDTO $comprobante,
        ?RequestOptions $options = null,
    ): RetencionResponseDTO {
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

        /** @var array<string, mixed> $dataArray */
        $dataArray = is_array($data) ? $data : [];

        return RetencionResponseDTO::fromTimbre($dataArray);
    }

    public function demo(
        RetencionTimbrarRequestDTO $comprobante,
        ?RequestOptions $options = null,
    ): RetencionResponseDTO {
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

        /** @var array<string, mixed> $dataArray */
        $dataArray = is_array($data) ? $data : [];

        return RetencionResponseDTO::fromTimbre($dataArray);
    }

    public function show(string $uuid, ?RequestOptions $options = null): RetencionResponseDTO
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

        /** @var array<string, mixed> $dataArray */
        $dataArray = is_array($data) ? $data : [];

        return RetencionResponseDTO::fromTimbre($dataArray);
    }

    /**
     * @return array<string, mixed>
     */
    public function cancel(
        RetencionCancelarRequestDTO $peticionCancelacion,
        ?RequestOptions $options = null,
        bool $isDemo = false,
    ): array {
        $uri = $isDemo
            ? '/demo' . self::ENDPOINT . '/cancelar'
            : self::ENDPOINT . '/cancelar';

        $request = $this->requestFactory->createRequest(
            uri: $uri,
            body: $peticionCancelacion,
            method: HttpMethod::POST,
            options: $options,
        );

        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        /** @var array<string, mixed> $result */
        $result = $body['data'] ?? $body;

        return $result;
    }

    /**
     * @param array<int, string> $emails
     *
     * @return array<string, mixed>
     */
    public function resend(string $uuid, array $emails, ?RequestOptions $options = null): array
    {
        $uri = self::ENDPOINT . "/{$uuid}/send";
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

        /** @var array<string, mixed> $result */
        $result = $body['data'] ?? $body;

        return $result;
    }
}
