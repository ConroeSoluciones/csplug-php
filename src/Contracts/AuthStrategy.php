<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Contracts;

use Csfacturacion\CsPlug\Model\RequestOptions;

/**
 * Strategy interface for authentication.
 */
interface AuthStrategy
{
    /**
     * Generate authorization header value.
     */
    public function getAuthorizationHeader(): string;

    /**
     * Get additional headers required by this auth strategy.
     *
     * @return array<string, string>
     */
    public function getAdditionalHeaders(?RequestOptions $options = null): array;
}
