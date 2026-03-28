<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use InvalidArgumentException;
use JsonSerializable;
use Override;

/**
 * DTO for timbrar (stamp) a CFDI.
 */
final class CfdiTimbrarRequestDTO implements JsonSerializable
{
    /** @var array<string, mixed> */
    private array $comprobante;

    /**
     * @param array<string, mixed> $comprobante
     */
    public function __construct(array $comprobante)
    {
        if ($comprobante === []) {
            throw new InvalidArgumentException('Comprobante cannot be empty');
        }

        $this->comprobante = $comprobante;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->comprobante;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->comprobante;
    }

    /**
     * @return array<string, mixed>
     */
    public function getComprobante(): array
    {
        return $this->comprobante;
    }
}
