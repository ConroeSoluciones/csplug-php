<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;

final class Certificado implements Deserializable
{
    public function __construct(
        public string $serieCertificado,
        public string $fechaInicial,
        public string $fechaFinal,
        public ?int $id = null
    ) {
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        
        return new self(
            $data['SERIECERTIFICADO'] ?? '',
            $data['FECHAINICIAL'] ?? '',
            $data['FECHAFINAL'] ?? '',
            isset($data['IDCERTIFICADO']) ? (int) $data['IDCERTIFICADO'] : null
        );
    }
}
