<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\DTOs\Requests\EmisorHijoRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\EmisorHijoResponseDTO;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;

use function array_key_exists;
use function array_map;
use function count;
use function is_array;
use function is_numeric;

final class EmisoresHijosResource extends BaseResource
{
    use ResponseHandlerTrait;

    private const ENDPOINT = '/emisores-hijos';

    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        /** @var array<string, string> $queryParams */
        $queryParams = $options?->getQuery() ?? [];

        $request = $this->requestFactory->createRequest(
            uri: self::ENDPOINT,
            queryParams: $queryParams,
            options: $options,
        );

        $response = $this->client->send($request);
        $this->handleResponse($response);

        $body = $response->bodyAsArray();

        /** @var list<EmisorHijoResponseDTO> $items */
        $items = array_map(
            /** @psalm-suppress MixedArgument */
            static fn (mixed $item): EmisorHijoResponseDTO => EmisorHijoResponseDTO::fromArray($item), // @phpstan-ignore argument.type
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

    public function create(
        EmisorHijoRequestDTO $emisorHijo,
        ?RequestOptions $options = null,
    ): EmisorHijoResponseDTO {
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

        return EmisorHijoResponseDTO::fromArray($data);
    }

    public function update(
        string $rfc,
        EmisorHijoRequestDTO $emisorHijo,
        ?RequestOptions $options = null,
    ): EmisorHijoResponseDTO {
        $request = $this->requestFactory->createRequest(
            uri: self::ENDPOINT . '/' . $rfc,
            body: $emisorHijo,
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

        return EmisorHijoResponseDTO::fromArray($data);
    }
}
