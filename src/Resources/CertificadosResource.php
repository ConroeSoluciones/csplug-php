<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Certificado;
use Csfacturacion\CsPlug\Model\CertificadoCsd;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\CsPlug\Error\ApiException;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

final class CertificadosResource extends BaseResource
{
    use ResponseHandlerTrait;

    /**
     * Get certificates for a child issuer (RFC).
     * @param string $rfc The child issuer RFC.
     * @param int $page Page number
     * @param RequestOptions|null $options
     * @return PaginatedResponse
     * @throws ApiException
     * @throws JsonException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Throwable
     */
    public function list(string $rfc, ?RequestOptions $options = null): PaginatedResponse
    {
        $path = sprintf('/emisores-hijos/%s/certificados', $rfc);
        $queryParams = $options?->getQuery() ?? [];

        $request = $this->requestFactory->createRequest(
            uri: $path,
            queryParams: $queryParams,
            options: $options
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        $data = $body['data'] ?? [];
        
        $items = array_map(
            static fn(array $item): Certificado => Certificado::fromArray($item),
            $data
        );

        return new PaginatedResponse(
            $items,
            (int) ($body['current_page'] ?? 1),
            (int) ($body['total'] ?? count($items))
        );
    }

    /**
     * Upload a new CSD certificate for a child issuer (RFC).
     * @param string $rfc The child issuer RFC.
     * @param CertificadoCsd $certificadoCsd The CSD data (key, cer, password).
     * @param RequestOptions|null $options
     * @return array The API response (or Certificado if applicable, though typically this returns a status message or similar).
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws JsonException
     * @throws Throwable
     */
    public function create(string $rfc, CertificadoCsd $certificadoCsd, ?RequestOptions $options = null): array
    {
        $path = sprintf('/emisores-hijos/%s/certificados', $rfc);
        
        $request = $this->requestFactory->createRequest(
            uri: $path,
            body: $certificadoCsd,
            method: HttpMethod::POST,
            options: $options
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        return $response->bodyAsArray();
    }
}
