<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

class Cfdi
{
    const TIPO_LIST = 'list';
    const TIPO_TIMBRE = 'timbre';
    public function __construct(
        readonly private string  $uuid,
        readonly private ?string $serie,
        readonly private string  $folio,
        readonly private string  $fecha,
        readonly private float   $subTotal,
        readonly private float   $total,
        readonly private ?float  $descuento = null,
        readonly private ?string $estatus = null,
        readonly private ?string $xmlBase64 = null,
        readonly private ?string $pdfBase64 = null,
        readonly private ?string $qrBase64 = null,
        readonly private string  $procedencia
    ){}

    private static function fromArray(array $data): self{
        return new self(
            uuid:           $data['uuid'],
            serie:          $data['serie'] ?? null,
            folio:          $data['folio'],
            fecha:          $data['fecha'] ?? '',
            subTotal:       (float) ($data['subTotal'] ?? 0),
            total:          (float) ($data['total'] ?? 0),
            descuento:      isset($data['descuento']) ? (float) $data['descuento'] : null,
            estatus:        $data['estatus'] ?? null,
            xmlBase64:      $data['xmlBase64'] ?? null,
            pdfBase64:      $data['pdfBase64'] ?? null,
            qrBase64:       $data['qrBase64'] ?? null,
            procedencia:    $data['procedencia']
        );
    }

    public static function fromTimbre(array $data): self{
        return self::fromArray([
            'uuid' =>       $data['cfdi']['uuid'],
            'serie' =>      $data['cfdi']['serie'],
            'folio' =>      $data['cfdi']['folio'],
            'fecha' =>      $data['cfdi']['fecha'],
            'subTotal' =>   (float) ($data['subTotal'] ?? 0),
            'total' =>      (float) ($data['total'] ?? 0),
            'descuento' =>  isset($data['descuento']) ? (float) $data['descuento'] : null,
            'xmlBase64' =>  $data['xml'],
            'pdfBase64' =>  $data['pdf'],
            'qrBase64' =>   $data['qr'],
            'procedencia'=> self::TIPO_TIMBRE
        ]);
    }

    public static function fromList(array $data): self{
        return self::fromArray([...$data, 'procedencia' => self::TIPO_LIST]);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function getFolio(): string
    {
        return $this->folio;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getDescuento(): ?float
    {
        return $this->descuento;
    }

    public function getEstatus(): ?string
    {
        return $this->estatus;
    }

    public function getXmlBase64(): ?string
    {
        return $this->xmlBase64;
    }

    public function getPdfBase64(): ?string
    {
        return $this->pdfBase64;
    }

    public function getQrBase64(): ?string
    {
        return $this->qrBase64;
    }

    public function getProcedencia(): string
    {
        return $this->procedencia;
    }
}