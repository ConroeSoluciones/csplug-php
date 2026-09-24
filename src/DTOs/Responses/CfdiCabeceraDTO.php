<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\Util\ArrayNormalizer;

/**
 * Cabecera de un CFDI.
 */
final readonly class CfdiCabeceraDTO
{
    public function __construct(
        public ?string $serie,
        public ?string $folio,
        public ?string $fecha,
        public ?string $hora,
        public ?string $estatus,
        public ?string $tipoCfdi,
        public ?string $tipoComprobante,
        public ?string $version,
        public ?string $moneda,
        public ?string $formaPago,
        public ?string $metodoPago,
        public ?string $usoCfdi,
        public ?string $lugarExpedicion,
        public ?float $subtotal,
        public ?float $descuento,
        public ?float $total,
        public CfdiEmisorDTO $emisor,
        public CfdiReceptorDTO $receptor,
    ) {
    }

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            serie: ArrayNormalizer::toNullableString($data['serie'] ?? null),
            folio: ArrayNormalizer::toNullableString($data['folio'] ?? null),
            fecha: ArrayNormalizer::toNullableString($data['fecha'] ?? null),
            hora: ArrayNormalizer::toNullableString($data['hora'] ?? null),
            estatus: ArrayNormalizer::toNullableString($data['estatus'] ?? null),
            tipoCfdi: ArrayNormalizer::toNullableString($data['tipo_cfdi'] ?? null),
            tipoComprobante: ArrayNormalizer::toNullableString($data['tipo_comprobante'] ?? null),
            version: ArrayNormalizer::toNullableString($data['version'] ?? null),
            moneda: ArrayNormalizer::toNullableString($data['moneda'] ?? null),
            formaPago: ArrayNormalizer::toNullableString($data['forma_pago'] ?? null),
            metodoPago: ArrayNormalizer::toNullableString($data['metodo_pago'] ?? null),
            usoCfdi: ArrayNormalizer::toNullableString($data['uso_cfdi'] ?? null),
            lugarExpedicion: ArrayNormalizer::toNullableString($data['lugar_expedicion'] ?? null),
            subtotal: ArrayNormalizer::toNullableFloat($data['subtotal'] ?? null),
            descuento: ArrayNormalizer::toNullableFloat($data['descuento'] ?? null),
            total: ArrayNormalizer::toNullableFloat($data['total'] ?? null),
            emisor: CfdiEmisorDTO::fromArray(
                ArrayNormalizer::toMap($data['emisor'] ?? null),
            ),
            receptor: CfdiReceptorDTO::fromArray(
                ArrayNormalizer::toMap($data['receptor'] ?? null),
            ),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'serie' => $this->serie,
            'folio' => $this->folio,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'estatus' => $this->estatus,
            'tipo_cfdi' => $this->tipoCfdi,
            'tipo_comprobante' => $this->tipoComprobante,
            'version' => $this->version,
            'moneda' => $this->moneda,
            'forma_pago' => $this->formaPago,
            'metodo_pago' => $this->metodoPago,
            'uso_cfdi' => $this->usoCfdi,
            'lugar_expedicion' => $this->lugarExpedicion,
            'subtotal' => $this->subtotal,
            'descuento' => $this->descuento,
            'total' => $this->total,
            'emisor' => $this->emisor->toArray(),
            'receptor' => $this->receptor->toArray(),
        ];
    }
}
