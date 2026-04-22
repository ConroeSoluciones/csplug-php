<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use function is_array;
use function is_numeric;
use function is_string;

/**
 * Response DTO for a CFDI (Comprobante Fiscal Digital por Internet).
 */
final readonly class CfdiResponseDTO
{
    public function __construct(
        public string $uuid,
        public ?string $serie,
        public string $folio,
        public string $fecha,
        public float $subTotal,
        public float $total,
        public string $procedencia,
        public ?float $descuento,
        public ?string $estatus,
        public ?string $xmlBase64,
        public ?string $pdfBase64,
        public ?string $qrBase64,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $cfdiData = is_array($data['cfdi'] ?? null) ? $data['cfdi'] : [];

        // Support various response formats from API
        $uuid = $cfdiData['uuid'] ?? $cfdiData['UUID'] ?? null;
        $serie = $cfdiData['serie'] ?? $cfdiData['SERIE'] ?? null;
        $folio = $cfdiData['folio'] ?? $cfdiData['FOLIO'] ?? null;
        $fecha = $cfdiData['fecha'] ?? $cfdiData['FECHA'] ?? null;
        $subTotal = $cfdiData['subTotal'] ?? $cfdiData['SUBTOTAL'] ?? 0;
        $total = $cfdiData['total'] ?? $cfdiData['TOTAL'] ?? 0;
        $descuento = $cfdiData['descuento'] ?? $cfdiData['DESCUENTO'] ?? null;
        $estatus = $cfdiData['estatus'] ?? $cfdiData['ESTATUS'] ?? null;
        $procedencia = $data['procedencia'] ?? $data['PROCEDENCIA'] ?? 'timbre';
        $xmlBase64 = $data['xml'] ?? $data['xmlBase64'] ?? $data['XML'] ?? null;
        $pdfBase64 = $data['pdf'] ?? $data['pdfBase64'] ?? $data['PDF'] ?? null;
        $qrBase64 = $data['qr'] ?? $data['qrBase64'] ?? $data['QR'] ?? null;

        return new self(
            uuid: is_string($uuid) ? $uuid : '',
            serie: is_string($serie) ? $serie : null,
            folio: is_string($folio) ? $folio : '',
            fecha: is_string($fecha) ? $fecha : '',
            subTotal: is_numeric($subTotal) ? (float) $subTotal : 0.0,
            total: is_numeric($total) ? (float) $total : 0.0,
            procedencia: is_string($procedencia) ? $procedencia : 'timbre',
            descuento: is_numeric($descuento) ? (float) $descuento : null,
            estatus: is_string($estatus) ? $estatus : null,
            xmlBase64: is_string($xmlBase64) ? $xmlBase64 : null,
            pdfBase64: is_string($pdfBase64) ? $pdfBase64 : null,
            qrBase64: is_string($qrBase64) ? $qrBase64 : null,
        );
    }

    /**
     * Create from timbre response format (nested cfdi array).
     *
     * @param array<string, mixed> $data
     */
    public static function fromTimbre(array $data): self
    {
        /** @var array<string, mixed> $cfdiData */
        $cfdiData = is_array($data['cfdi'] ?? null) ? $data['cfdi'] : [];

        $mergedData = [
            'uuid' => $cfdiData['uuid'] ?? $cfdiData['UUID'] ?? null,
            'serie' => $cfdiData['serie'] ?? $cfdiData['SERIE'] ?? null,
            'folio' => $cfdiData['folio'] ?? $cfdiData['FOLIO'] ?? null,
            'fecha' => $cfdiData['fecha'] ?? $cfdiData['FECHA'] ?? null,
            'subTotal' => $cfdiData['subTotal'] ?? $cfdiData['SUBTOTAL'] ?? 0,
            'total' => $cfdiData['total'] ?? $cfdiData['TOTAL'] ?? 0,
            'descuento' => $cfdiData['descuento'] ?? $cfdiData['DESCUENTO'] ?? null,
            'xml' => $data['xml'] ?? null,
            'pdf' => $data['pdf'] ?? null,
            'qr' => $data['qr'] ?? null,
            'procedencia' => 'timbre',
        ];

        return self::fromArray($mergedData);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'serie' => $this->serie,
            'folio' => $this->folio,
            'fecha' => $this->fecha,
            'subTotal' => $this->subTotal,
            'total' => $this->total,
            'procedencia' => $this->procedencia,
            'descuento' => $this->descuento,
            'estatus' => $this->estatus,
            'xmlBase64' => $this->xmlBase64,
            'pdfBase64' => $this->pdfBase64,
            'qrBase64' => $this->qrBase64,
        ];
    }
}
