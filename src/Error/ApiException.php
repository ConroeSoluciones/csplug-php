<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Error;

class ApiException extends CsPlugError
{
    public function __construct(
        string $message,
        int $code = 0,
        ?\Throwable $previous = null,
        public ?array $responseBody = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
