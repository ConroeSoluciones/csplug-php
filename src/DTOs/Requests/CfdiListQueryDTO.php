<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use Csfacturacion\CsPlug\Model\CfdiEstatus;
use InvalidArgumentException;
use JsonSerializable;
use Override;

use function in_array;
use function preg_match;

/**
 * DTO con los filtros de listado de CFDIs (GET /cfdi).
 */
final class CfdiListQueryDTO implements JsonSerializable
{
    private const array TIPOS_COMPROBANTE_VALIDOS = ['I', 'E', 'T', 'N', 'P', 'Retencion'];

    public int $page = 1;
    public int $pageSize = 20;

    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $serie = null;
    private ?string $tipoComprobante = null;
    private ?CfdiEstatus $estatus = null;
    private ?string $rfcAcuentaTerceros = null;
    private ?string $rfcEmisor = null;

    public function withPage(int $page): self
    {
        if ($page < 1) {
            throw new InvalidArgumentException('Page must be greater or equal than 1');
        }

        $this->page = $page;

        return $this;
    }

    public function withPageSize(int $pageSize): self
    {
        if ($pageSize < 1) {
            throw new InvalidArgumentException('PageSize must be greater or equal than 1');
        }

        $this->pageSize = $pageSize;

        return $this;
    }

    public function withStartDate(string $startDate): self
    {
        $this->validateDate($startDate, 'StartDate');

        $this->startDate = $startDate;

        return $this;
    }

    public function withEndDate(string $endDate): self
    {
        $this->validateDate($endDate, 'EndDate');

        $this->endDate = $endDate;

        return $this;
    }

    public function withSerie(string $serie): self
    {
        if ($serie === '') {
            throw new InvalidArgumentException('Serie cannot be empty');
        }

        $this->serie = $serie;

        return $this;
    }

    public function withTipoComprobante(string $tipoComprobante): self
    {
        if (
            !in_array($tipoComprobante, self::TIPOS_COMPROBANTE_VALIDOS, true)
        ) {
            throw new InvalidArgumentException('TipoComprobante must be I, E, T, N, P or Retencion');
        }

        $this->tipoComprobante = $tipoComprobante;

        return $this;
    }

    public function withEstatus(CfdiEstatus $estatus): self
    {
        $this->estatus = $estatus;

        return $this;
    }

    public function withRfcAcuentaTerceros(string $rfcAcuentaTerceros): self
    {
        if ($rfcAcuentaTerceros === '') {
            throw new InvalidArgumentException('RfcAcuentaTerceros cannot be empty');
        }

        $this->rfcAcuentaTerceros = $rfcAcuentaTerceros;

        return $this;
    }

    public function withRfcEmisor(string $rfcEmisor): self
    {
        if ($rfcEmisor === '') {
            throw new InvalidArgumentException('RfcEmisor cannot be empty');
        }

        $this->rfcEmisor = $rfcEmisor;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $data = [
            'page' => (string) $this->page,
            'page_size' => (string) $this->pageSize,
        ];

        if ($this->startDate !== null) {
            $data['start_date'] = $this->startDate;
        }

        if ($this->endDate !== null) {
            $data['end_date'] = $this->endDate;
        }

        if ($this->serie !== null) {
            $data['serie'] = $this->serie;
        }

        if ($this->tipoComprobante !== null) {
            $data['tipo_comprobante'] = $this->tipoComprobante;
        }

        if ($this->estatus !== null) {
            $data['estatus'] = (string) $this->estatus->value;
        }

        if ($this->rfcAcuentaTerceros !== null) {
            $data['rfc_acuenta_terceros'] = $this->rfcAcuentaTerceros;
        }

        if ($this->rfcEmisor !== null) {
            $data['rfc_emisor'] = $this->rfcEmisor;
        }

        return $data;
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    private function validateDate(string $value, string $field): void
    {
        if ($value === '') {
            throw new InvalidArgumentException($field . ' cannot be empty');
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            throw new InvalidArgumentException($field . ' must be a valid date (YYYY-MM-DD)');
        }
    }
}
