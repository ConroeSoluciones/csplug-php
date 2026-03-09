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

use function array_key_exists;
use function array_map;
use function array_values;
use function count;
use function is_array;
use function is_numeric;

final class EmisoresHijosResource extends BaseResource
{
    use ResponseHandlerTrait;

    private const ENDPOINT = '/emisores-hijos';

    /**
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
            static fn (mixed $item): EmisorHijo => EmisorHijo::fromArray($item), // @phpstan-ignore argument.type
            $dataList,
        );

        return new PaginatedResponse(
            $items,
            is_numeric($body['current_page'] ?? null) ? (int) $body['current_page'] : 1,
            is_numeric($body['total'] ?? null) ? (int) $body['total'] : count($items),
        );
    }

    /**
     * Creates a new EmisorHijo resource.
     *
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
            options: $options,
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $rawData */
        $rawData = array_key_exists('data', $body) ? $body['data'] : $body;
        /** @var array<string, mixed> $data */
        $data = is_array($rawData) ? $rawData : [];

        return EmisorHijo::fromArray($data);
    }
}
