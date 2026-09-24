<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\Util\ArrayNormalizer;

/**
 * Datos del emisor de un CFDI.
 */
final readonly class CfdiEmisorDTO
{
    public function __construct(
        public string $rfc,
        public string $razonSocial,
        public ?string $regimenFiscal,
    ) {
    }

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            rfc: ArrayNormalizer::toString($data['rfc'] ?? null),
            razonSocial: ArrayNormalizer::toString($data['razon_social'] ?? null),
            regimenFiscal: ArrayNormalizer::toNullableString($data['regimen_fiscal'] ?? null),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'rfc' => $this->rfc,
            'razon_social' => $this->razonSocial,
            'regimen_fiscal' => $this->regimenFiscal,
        ];
    }
}
