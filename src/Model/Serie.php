<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;

final class Serie implements Deserializable, \JsonSerializable
{
    public function __construct(
        public string $serie,
        public int $rangoInicial,
        public ?int $id = null,
        public ?int $decimales = 2,
        public ?string $rfcEmisor = null,
        public ?string $tipoComprobante = 'INGRESO',
        public ?string $tipoDocumento = 'CFDI',
        public ?string $logo = null,
        public ?int $plantillaId = null
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['SERIE'] ?? $data['serie'] ?? '',
            (int) ($data['RANGOINICIAL'] ?? $data['rango_inicial'] ?? 0),
            isset($data['IDSERIE']) ? (int) $data['IDSERIE'] : null,
            isset($data['DECIMALES']) ? (int) $data['DECIMALES'] : ((int) ($data['cantidad_decimales'] ?? 2)),
            $data['RFCEMISOR'] ?? null,
            $data['tipo_comprobante'] ?? 'INGRESO',
            $data['tipo_documento'] ?? 'CFDI',
            $data['logo'] ?? null,
            isset($data['plantilla_id']) ? (int) $data['plantilla_id'] : null
        );
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return self::fromArray($data);
    }

    public function jsonSerialize(): array
    {
        $data = [
            'serie' => $this->serie,
            'rango_inicial' => $this->rangoInicial,
            'cantidad_decimales' => $this->decimales,
            'tipo_comprobante' => $this->tipoComprobante,
            'tipo_documento' => $this->tipoDocumento,
        ];

        if ($this->logo !== null) {
            $data['logo'] = $this->logo;
        }

        if ($this->plantillaId !== null) {
            $data['plantilla_id'] = $this->plantillaId;
        }

        return $data;
    }
}
