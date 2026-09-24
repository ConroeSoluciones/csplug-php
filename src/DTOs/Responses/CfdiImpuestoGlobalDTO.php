<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\Util\ArrayNormalizer;

use function is_string;

/**
 * Impuestos globales de un CFDI.
 */
final readonly class CfdiImpuestoGlobalDTO
{
    /**
     * @param list<array<string, mixed>>|null $traslados
     * @param list<array<string, mixed>>|null $retenciones
     */
    public function __construct(
        public ?string $totalImpuestosTrasladados,
        public ?string $totalImpuestosRetenidos,
        public ?array $traslados,
        public ?array $retenciones,
    ) {
    }

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            totalImpuestosTrasladados: self::toStringOrNull($data['total_impuestos_trasladados'] ?? null),
            totalImpuestosRetenidos: self::toStringOrNull($data['total_impuestos_retenidos'] ?? null),
            traslados: ArrayNormalizer::toListOfMapsOrNull($data['traslados'] ?? null),
            retenciones: ArrayNormalizer::toListOfMapsOrNull($data['retenciones'] ?? null),
        );
    }

    private static function toStringOrNull(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'total_impuestos_trasladados' => $this->totalImpuestosTrasladados,
            'total_impuestos_retenidos' => $this->totalImpuestosRetenidos,
            'traslados' => $this->traslados,
            'retenciones' => $this->retenciones,
        ];
    }
}
