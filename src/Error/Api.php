<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Error;

use Throwable;

class Api extends CsPlugError
{
    /**
     * @param array<mixed>|null $responseBody
     */
    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $previous = null,
        public ?array $responseBody = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
