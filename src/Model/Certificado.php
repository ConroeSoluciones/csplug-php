<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use InvalidArgumentException;
use JsonException;
use Override;

use function is_array;
use function is_string;
use function json_decode;

use const JSON_THROW_ON_ERROR;

final class Certificado implements Deserializable
{
    /**
     * @throws JsonException
     */
    #[Override]
    public static function fromJson(string $raw): self
    {
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new InvalidArgumentException('Invalid JSON data provided');
        }

        /**
         * @var array<string, int|string|null> $data
         */
        return self::fromArray($data);
    }

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

    /**
     * @internal
     *
     * @param array<string, int|string|null> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            serieCertificado: isset($data['SERIECERTIFICADO']) && is_string($data['SERIECERTIFICADO'])
                ? $data['SERIECERTIFICADO']
                : '',
            inicioVigencia: isset($data['INICIOVIGENCIA']) && is_string($data['INICIOVIGENCIA'])
                ? $data['INICIOVIGENCIA']
                : '',
            finVigencia: isset($data['FINVIGENCIA']) && is_string($data['FINVIGENCIA']) ? $data['FINVIGENCIA'] : '',
            fecha: isset($data['FECHA']) && is_string($data['FECHA']) ? $data['FECHA'] : '',
            tipo: isset($data['TIPO']) ? (int) $data['TIPO'] : 0,
            tipoCertificado: isset($data['TIPOCERTIFICADO'])
                ? (int) $data['TIPOCERTIFICADO']
                : 0,
            estatus: isset($data['ESTATUS']) ? (int) $data['ESTATUS'] : 0,
            url: isset($data['URL']) && is_string($data['URL']) ? $data['URL'] : null,
            fechaInicial: isset($data['FECHAINICIAL']) && is_string($data['FECHAINICIAL'])
                ? $data['FECHAINICIAL']
                : '',
            fechaFinal: isset($data['FECHAFINAL']) && is_string($data['FECHAFINAL'])
                ? $data['FECHAFINAL']
                : '',
            rfcEmisor: isset($data['RFCEMISOR']) && is_string($data['RFCEMISOR'])
                ? $data['RFCEMISOR']
                : '',
        );
    }
}
