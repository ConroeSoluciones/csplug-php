<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;

final class Plantilla implements Deserializable
{
    public function __construct(
        public int $id,
        public string $nombreService,
        public string $clavePlantilla
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) ($data['IDPLANTILLA'] ?? 0),
            $data['NOMBRE_SERVICE'] ?? '',
            $data['CLAVEPLANTILLA'] ?? ''
        );
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return self::fromArray($data);
    }
}
