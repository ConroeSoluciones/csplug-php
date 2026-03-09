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

final class CertificadosResource extends BaseResource
{
    use ResponseHandlerTrait;

    /**
     * Get global certificates.
     *
     * @throws JsonException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Throwable
     */
    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $path = '/certificados';
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
            isset($body['current_page']) && is_numeric($body['current_page'])
                ? (int) $body['current_page']
                : 1,
            isset($body['total']) && is_numeric($body['total'])
                ? (int) $body['total']
                : count($items),
        );
    }

    /**
     * Upload a new global CSD certificate.
     *
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
    public function create(CertificadoCsd $certificadoCsd, ?RequestOptions $options = null): array
    {
        $path = '/certificados';

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
