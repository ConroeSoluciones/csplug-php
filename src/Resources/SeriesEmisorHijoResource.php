<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\DTOs\Requests\SerieConfigRequestDTO;
use Csfacturacion\CsPlug\DTOs\Requests\SerieRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\SerieConfigResponseDTO;
use Csfacturacion\CsPlug\DTOs\Responses\SerieResponseDTO;
use Csfacturacion\CsPlug\Error\NotFound;
use Csfacturacion\CsPlug\Error\Unauthorized;
use Csfacturacion\CsPlug\Error\Validation;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;

use function array_key_exists;
use function array_map;
use function count;
use function is_array;
use function is_numeric;
use function sprintf;

/**
 * Child Series Resource (/emisores-hijos/{rfc}/series)
 */
final class SeriesEmisorHijoResource extends BaseResource
{
    use ResponseHandlerTrait;

    public function list(string $rfc, ?RequestOptions $options = null): PaginatedResponse
    {
        $path = sprintf('/emisores-hijos/%s/series', $rfc);

        /** @var array<string, string> $queryParams */
        $queryParams = $options?->getQuery() ?? [];

        $request = $this->requestFactory->createRequest(
            uri: $path,
            queryParams: $queryParams,
            options: $options,
        );
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        /** @var list<SerieResponseDTO> $items */
        $items = array_map(
            /** @psalm-suppress MixedArgument */
            static fn (mixed $item): SerieResponseDTO => SerieResponseDTO::fromArray($item), // @phpstan-ignore argument.type
            (array) ($body['data'] ?? []),
        );

        /** @var array<string, mixed> $pagination */
        $pagination = $body['pagination'] ?? [];

        return new PaginatedResponse(
            $items,
            is_numeric($pagination['current_page'] ?? null)
                ? (int) $pagination['current_page']
                : 1,
            is_numeric($pagination['total'] ?? null)
                ? (int) $pagination['total']
                : count($items),
        );
    }

    public function show(string $rfc, int $idSerie, ?RequestOptions $options = null): SerieResponseDTO
    {
        $path = sprintf('/emisores-hijos/%s/series/%d', $rfc, $idSerie);

        $request = $this->requestFactory->createRequest(
            uri: $path,
            options: $options,
        );
        $response = $this->client->send($request);

        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        /** @var mixed $rawData */
        $rawData = array_key_exists('data', $body) ? $body['data'] : $body;
        /** @var array<string, mixed> $data */
        $data = is_array($rawData) ? $rawData : [];

        return SerieResponseDTO::fromArray($data);
    }

    public function create(string $rfc, SerieRequestDTO $serie, ?RequestOptions $options = null): SerieResponseDTO
    {
        $path = sprintf('/emisores-hijos/%s/series', $rfc);

        $request = $this->requestFactory->createRequest(
            uri: $path,
            body: $serie,
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

        return SerieResponseDTO::fromArray($data);
    }

    /**
     * Update an existing serie.
     *
     * @throws NotFound When serie not found
     * @throws Validation When validation fails
     * @throws Unauthorized When authentication fails
     */
    public function update(
        string $rfc,
        int $idSerie,
        SerieRequestDTO $serie,
        ?RequestOptions $options = null,
    ): SerieResponseDTO {
        $path = sprintf('/emisores-hijos/%s/series/%d', $rfc, $idSerie);

        $request = $this->requestFactory->createRequest(
            uri: $path,
            body: $serie,
            method: HttpMethod::PUT,
            options: $options,
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $rawData */
        $rawData = array_key_exists('data', $body) ? $body['data'] : $body;
        /** @var array<string, mixed> $data */
        $data = is_array($rawData) ? $rawData : [];

        return SerieResponseDTO::fromArray($data);
    }

    /**
     * Configure a serie with custom settings.
     *
     * @throws NotFound When serie not found
     * @throws Validation When validation fails
     * @throws Unauthorized When authentication fails
     */
    public function configure(
        string $rfc,
        int $idSerie,
        SerieConfigRequestDTO $config,
        ?RequestOptions $options = null,
    ): SerieConfigResponseDTO {
        $path = sprintf('/emisores-hijos/%s/series/%d/config', $rfc, $idSerie);

        $request = $this->requestFactory->createRequest(
            uri: $path,
            body: $config,
            method: HttpMethod::PUT,
            options: $options,
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();
        /** @var mixed $rawData */
        $rawData = array_key_exists('data', $body) ? $body['data'] : $body;
        /** @var array<string, mixed> $data */
        $data = is_array($rawData) ? $rawData : [];

        return SerieConfigResponseDTO::fromArray($data);
    }
}
