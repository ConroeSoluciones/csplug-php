<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\Util\ArrayNormalizer;

/**
 * Datos del receptor de un CFDI.
 */
final readonly class CfdiReceptorDTO
{
    public function __construct(
        public string $rfc,
        public string $razonSocial,
        public ?string $codigoPostal,
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
            codigoPostal: ArrayNormalizer::toNullableString($data['codigo_postal'] ?? null),
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
            'codigo_postal' => $this->codigoPostal,
        ];
    }
}
