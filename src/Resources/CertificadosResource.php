<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Certificado;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\CsPlug\Error\ApiException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class CertificadosResource extends BaseResource
{
    use ResponseHandlerTrait;

    /**
     * Get certificates for a child issuer (RFC).
     * @param string $rfc The child issuer RFC.
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
    public function list(string $rfc, int $page = 1, ?RequestOptions $options = null): PaginatedResponse
    {
        $path = sprintf('/emisores-hijos/%s/certificados?page=%d', $rfc, $page);
        $request = $this->requestFactory->createRequest('GET', $path, $options);
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->toArray(); // { message, data: [...] }
        
        $items = array_map(
            fn($item) => Certificado::fromJson(json_encode($item)), 
            $body['data'] ?? []
        );

        return new PaginatedResponse(
            $items,
            1, // API might not paginate strictly here, but assuming it does or returns all
            count($items)
        );
    }
}
