<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Auth;

use Csfacturacion\CsPlug\Contracts\AuthStrategy;
use Csfacturacion\CsPlug\Model\AuthMode;
use Csfacturacion\CsPlug\Model\CsPlugConfig;

/**
 * Factory for creating authentication strategies.
 */
final readonly class AuthStrategyFactory
{
    public static function create(CsPlugConfig $config): AuthStrategy
    {
        return match ($config->getAuthMode()) {
            AuthMode::BASIC => new BasicAuthStrategy($config),
            AuthMode::BEARER => new BearerAuthStrategy($config),
        };
    }
}
