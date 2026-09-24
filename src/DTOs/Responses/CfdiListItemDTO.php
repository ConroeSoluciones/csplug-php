<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\Util\ArrayNormalizer;

use function array_map;

/**
 * Item del listado de CFDIs (GET /cfdi).
 */
final readonly class CfdiListItemDTO
{
    /**
     * @param list<CfdiConceptoDTO> $conceptos
     * @param list<CfdiImpuestoGlobalDTO> $impuestosGlobales
     * @param list<array<string, mixed>>|null $datosExtra
     */
    public function __construct(
        public string $uuid,
        public ?string $fecha,
        public ?float $total,
        public ?string $estatus,
        public ?string $folio,
        public CfdiCabeceraDTO $cabecera,
        public array $conceptos,
        public array $impuestosGlobales,
        public ?array $datosExtra,
    ) {
    }

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            uuid: ArrayNormalizer::toString($data['UUID'] ?? null),
            fecha: ArrayNormalizer::toNullableString($data['FECHA'] ?? null),
            total: ArrayNormalizer::toNullableFloat($data['TOTAL'] ?? null),
            estatus: ArrayNormalizer::toNullableString($data['ESTATUS'] ?? null),
            folio: ArrayNormalizer::toNullableString($data['FOLIO'] ?? null),
            cabecera: CfdiCabeceraDTO::fromArray(
                ArrayNormalizer::toMap($data['cabecera'] ?? null),
            ),
            conceptos: array_map(
                static fn (array $item): CfdiConceptoDTO => CfdiConceptoDTO::fromArray($item),
                ArrayNormalizer::toListOfMaps($data['conceptos'] ?? null),
            ),
            impuestosGlobales: array_map(
                static fn (array $item): CfdiImpuestoGlobalDTO => CfdiImpuestoGlobalDTO::fromArray($item),
                ArrayNormalizer::toListOfMaps($data['impuestos_globales'] ?? null),
            ),
            datosExtra: ArrayNormalizer::toListOfMapsOrNull($data['datos_extra'] ?? null),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'UUID' => $this->uuid,
            'FECHA' => $this->fecha,
            'TOTAL' => $this->total,
            'ESTATUS' => $this->estatus,
            'FOLIO' => $this->folio,
            'cabecera' => $this->cabecera->toArray(),
            'conceptos' => array_map(
                static fn (CfdiConceptoDTO $concepto): array => $concepto->toArray(),
                $this->conceptos,
            ),
            'impuestos_globales' => array_map(
                static fn (CfdiImpuestoGlobalDTO $impuesto): array => $impuesto->toArray(),
                $this->impuestosGlobales,
            ),
            'datos_extra' => $this->datosExtra,
        ];
    }
}
