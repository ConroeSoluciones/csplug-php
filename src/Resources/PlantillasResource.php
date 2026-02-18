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
        $request = $this->requestFactory->createRequest('GET', '/plantillas', $options);
        $response = $this->client->send($request);

        $this->handleResponse($response);
        
        $body = $response->toArray();
        
        $items = array_map(
            fn($item) => Plantilla::fromJson(json_encode($item)), 
            $body['data'] ?? []
        );

        return new PaginatedResponse(
            $items,
            1,
            count($items)
        );
    }
}
