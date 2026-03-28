<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Auth;

use Csfacturacion\CsPlug\Contracts\AuthStrategy;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Override;

use function base64_encode;

/**
 * Basic authentication strategy using username and password.
 */
final readonly class BasicAuthStrategy implements AuthStrategy
{
    public function __construct(
        private CsPlugConfig $config,
    ) {
    }

    #[Override]
    public function getAuthorizationHeader(): string
    {
        return base64_encode($this->config->getUsername() . ':' . $this->config->getPassword());
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function getAdditionalHeaders(?RequestOptions $options = null): array
    {
        return [];
    }
}
