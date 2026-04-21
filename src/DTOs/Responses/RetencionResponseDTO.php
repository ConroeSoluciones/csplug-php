<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use function is_array;
use function is_numeric;
use function is_string;

/**
 * Response DTO for a Retención.
 */
final readonly class RetencionResponseDTO
{
    public function __construct(
        public string $uuid,
        public ?string $serie,
        public string $folio,
        public string $fecha,
        public float $total,
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
        // Support various response formats from API
        $uuid = $data['uuid'] ?? $data['UUID'] ?? null;
        $serie = $data['serie'] ?? $data['SERIE'] ?? null;
        $folio = $data['folio'] ?? $data['FOLIO'] ?? null;
        $fecha = $data['fecha'] ?? $data['FECHA'] ?? null;
        $total = $data['total'] ?? $data['TOTAL'] ?? 0;
        $estatus = $data['estatus'] ?? $data['ESTATUS'] ?? null;
        $xmlBase64 = $data['xml'] ?? $data['xmlBase64'] ?? $data['XML'] ?? null;
        $pdfBase64 = $data['pdf'] ?? $data['pdfBase64'] ?? $data['PDF'] ?? null;
        $qrBase64 = $data['qr'] ?? $data['qrBase64'] ?? $data['QR'] ?? null;

        return new self(
            uuid: is_string($uuid) ? $uuid : '',
            serie: is_string($serie) ? $serie : null,
            folio: is_string($folio) ? $folio : '',
            fecha: is_string($fecha) ? $fecha : '',
            total: is_numeric($total) ? (float) $total : 0.0,
            estatus: is_string($estatus) ? $estatus : null,
            xmlBase64: is_string($xmlBase64) ? $xmlBase64 : null,
            pdfBase64: is_string($pdfBase64) ? $pdfBase64 : null,
            qrBase64: is_string($qrBase64) ? $qrBase64 : null,
        );
    }

    /**
     * Create from timbre response format (nested retencion array).
     *
     * @param array<string, mixed> $data
     */
    public static function fromTimbre(array $data): self
    {
        /** @var array<string, mixed> $retencionData */
        $retencionData = is_array($data['cfdi'] ?? null) ? $data['cfdi'] : [];

        $mergedData = [
            'uuid' => $retencionData['uuid'] ?? $retencionData['UUID'] ?? null,
            'serie' => $retencionData['serie'] ?? $retencionData['SERIE'] ?? null,
            'folio' => $retencionData['folio'] ?? $retencionData['FOLIO'] ?? null,
            'fecha' => $retencionData['fecha'] ?? $retencionData['FECHA'] ?? null,
            'total' => $retencionData['total'] ?? $retencionData['TOTAL'] ?? 0,
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
            'total' => $this->total,
            'estatus' => $this->estatus,
            'xmlBase64' => $this->xmlBase64,
            'pdfBase64' => $this->pdfBase64,
            'qrBase64' => $this->qrBase64,
        ];
    }
}
