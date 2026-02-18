<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Error;

use Csfacturacion\CsPlug\Model\HttpResponse;

class ExceptionFactory
{
    public static function createFromResponse(HttpResponse $response): ApiException
    {
        $body = $response->toArray();
        $message = $body['message'] ?? 'Unknown Error';
        
        return match ($response->statusCode) {
            400 => new ValidationException($message, 400, null, $body),
            401 => new UnauthorizedException('Unauthorized: ' . $message, 401, null, $body),
            404 => new NotFoundException('Not Found: ' . $message, 404, null, $body),
            default => new ApiException('HTTP Error: ' . $message, $response->statusCode, null, $body),
        };
    }
}
