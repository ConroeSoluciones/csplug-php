<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;

final class Certificado implements Deserializable
{
    public function __construct(
        public string $serieCertificado,
        public string $inicioVigencia,
        public string $finVigencia,
        public string $fecha,
        public int $tipo,
        public int $tipoCertificado,
        public int $estatus,
        public ?string $url,
        public string $fechaInicial,
        public string $fechaFinal,
        public string $rfcEmisor,
    ) {
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        return self::fromArray($data);
    }

    /**
     *
     * @internal
     * */
    public static function fromArray(array $data): self
    {
        return new self(
            serieCertificado: $data['SERIECERTIFICADO'] ?? '',
            inicioVigencia: $data['INICIOVIGENCIA'] ?? '',
            finVigencia: $data['FINVIGENCIA'] ?? '',
            fecha: $data['FECHA'] ?? '',
            tipo: (int) ($data['TIPO'] ?? 0),
            tipoCertificado: (int) ($data['TIPOCERTIFICADO'] ?? 0),
            estatus: (int) ($data['ESTATUS'] ?? 0),
            url: $data['URL'] ?? null,
            fechaInicial: $data['FECHAINICIAL'] ?? '',
            fechaFinal: $data['FECHAFINAL'] ?? '',
            rfcEmisor: $data['RFCEMISOR'] ?? ''
        );
    }
}
