<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Resources;

use Csfacturacion\CsPlug\Model\Plantilla;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Model\RequestOptions;

final class PlantillasResource extends BaseResource
{
    use ResponseHandlerTrait;

    public function list(?RequestOptions $options = null): PaginatedResponse
    {
        $request = $this->requestFactory->createRequest(
            uri: '/plantillas',
            options: $options
        );
        $response = $this->client->send($request);

        $this->handleResponse($response);
        
        $body = $response->bodyAsArray();
        
        $items = array_map(
            fn($item) => Plantilla::fromArray($item), 
            $body['data'] ?? []
        );

        return new PaginatedResponse(
            $items,
            1,
            count($items)
        );
    }
}
