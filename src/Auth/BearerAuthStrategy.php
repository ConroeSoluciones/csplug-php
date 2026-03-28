<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Auth;

use Csfacturacion\CsPlug\Contracts\AuthStrategy;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Override;

/**
 * Bearer token authentication strategy.
 */
final readonly class BearerAuthStrategy implements AuthStrategy
{
    public function __construct(
        private CsPlugConfig $config,
    ) {
    }

    #[Override]
    public function getAuthorizationHeader(): string
    {
        return 'Bearer ' . $this->config->getBearerToken();
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function getAdditionalHeaders(?RequestOptions $options = null): array
    {
        $xRfc = $options?->getContractId() ?? $this->config->getContractId();

        return [
            'X-Rfc' => $xRfc,
        ];
    }
}
