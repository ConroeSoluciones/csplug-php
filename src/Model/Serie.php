<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;

final class Serie implements Deserializable
{
    public function __construct(
        public string $serie,
        public int $rangoInicial,
        public ?int $id = null,
        public ?int $decimales = null,
        public ?string $rfcEmisor = null
    ) {
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return new self(
            $data['SERIE'] ?? '',
            (int) ($data['RANGOINICIAL'] ?? 0),
            isset($data['IDSERIE']) ? (int) $data['IDSERIE'] : null,
            isset($data['DECIMALES']) ? (int) $data['DECIMALES'] : null,
            $data['RFCEMISOR'] ?? null
        );
    }
}
