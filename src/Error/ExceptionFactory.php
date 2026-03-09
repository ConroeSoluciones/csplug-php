<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Error;

use Csfacturacion\CsPlug\Model\HttpResponse;
use RuntimeException;

use function is_string;

final class ExceptionFactory
{
    public static function createFromResponse(HttpResponse $response): Api
    {
        $body = $response->bodyAsArray();
        /**
         * @var array<string, mixed> $body
         */
        $message = $body['message'] ?? 'El response no contienen un message';
        if (!is_string($message)) {
            throw new RuntimeException('Invalid message type');
        }

        return match ($response->getCode()) {
            400 => new Validation($message, 400, null, $body),
            401 => new Unauthorized('Unauthorized: ' . $message, 401, null, $body),
            404 => new NotFound('Not Found: ' . $message, 404, null, $body),
            default => new Api('HTTP Error: ' . $message, $response->getCode(), null, $body),
        };
    }
}
