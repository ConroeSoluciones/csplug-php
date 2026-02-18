<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;

final class EmisorHijo implements Deserializable
{
    public function __construct(
        public string $rfc,
        public string $razonSocial,
        public string $domicilioFiscal,
        public array $configuracion
    ) {
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return new self(
            $data['RFC'] ?? $data['rfc'] ?? '',
            $data['RAZONSOCIAL'] ?? $data['razon_social'] ?? '',
            $data['DOMICILIOFISCAL'] ?? $data['domicilio_fiscal'] ?? '',
            $data['CONFIGURACION'] ?? $data['config'] ?? []
        );
    }
}
