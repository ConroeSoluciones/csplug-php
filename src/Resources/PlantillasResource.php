<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\Plantilla;
use Csfacturacion\CsPlug\Model\RequestOptions;

use function array_map;
use function array_values;
use function count;
use function is_array;

final class PlantillasResource extends BaseResource
{
    use ResponseHandlerTrait;

    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $request = $this->requestFactory->createRequest(
            uri: '/plantillas',
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
            static fn (mixed $item): Plantilla => Plantilla::fromArray($item), // @phpstan-ignore argument.type
            $dataList,
        );

        return new PaginatedResponse(
            $items,
            1,
            count($items),
        );
    }
}
