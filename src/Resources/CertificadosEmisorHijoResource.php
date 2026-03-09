<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Certificado;
use Csfacturacion\CsPlug\Model\CertificadoCsd;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

use function array_map;
use function array_values;
use function count;
use function is_array;
use function is_numeric;
use function sprintf;

final class CertificadosEmisorHijoResource extends BaseResource
{
    use ResponseHandlerTrait;

    /**
     * Get certificates for a child issuer (RFC).
     *
     * @param string $rfc The child issuer RFC.
     *
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
            options: $options,
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $rawData */
        $rawData = $body['data'] ?? [];
        $dataList = is_array($rawData) ? array_values($rawData) : [];

        $items = array_map(
            /** @psalm-suppress MixedArgument */
            static fn (mixed $item): Certificado => Certificado::fromArray($item), // @phpstan-ignore argument.type
            $dataList,
        );

        return new PaginatedResponse(
            $items,
            is_numeric($body['current_page'] ?? null) ? (int) $body['current_page'] : 1,
            is_numeric($body['total'] ?? null) ? (int) $body['total'] : count($items),
        );
    }

    /**
     * Upload a new CSD certificate for a child issuer (RFC).
     *
     * @param string $rfc The child issuer RFC.
     * @param CertificadoCsd $certificadoCsd The CSD data (key, cer, password).
     *
     * @return array<string, mixed> The API response.
     *
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
            options: $options,
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        return $response->bodyAsArray();
    }
}
