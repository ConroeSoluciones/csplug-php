<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\DTOs\Requests\CfdiCancelarRequestDTO;
use Csfacturacion\CsPlug\DTOs\Requests\CfdiTimbrarRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\CfdiResponseDTO;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\RequestOptions;

use function is_array;

final class CfdiResource extends BaseResource
{
    use ResponseHandlerTrait;

    private const ENDPOINT = '/cfdi';

    public function timbrar(
        CfdiTimbrarRequestDTO $comprobante,
        ?RequestOptions $options = null,
    ): CfdiResponseDTO {
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

        return CfdiResponseDTO::fromTimbre($dataArray);
    }

    public function demo(
        CfdiTimbrarRequestDTO $comprobante,
        ?RequestOptions $options = null,
    ): CfdiResponseDTO {
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

        return CfdiResponseDTO::fromTimbre($dataArray);
    }

    public function show(string $uuid, ?RequestOptions $options = null): CfdiResponseDTO
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

        return CfdiResponseDTO::fromArray($dataArray);
    }

    /**
     * @return array<string, mixed>
     */
    public function cancel(
        CfdiCancelarRequestDTO $peticionCancelacion,
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
