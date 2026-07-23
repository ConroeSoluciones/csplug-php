<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use InvalidArgumentException;

use function filter_var;
use function is_array;
use function is_int;
use function is_string;

use const FILTER_VALIDATE_INT;

/**
 * Response DTO for a Serie.
 */
final readonly class SerieResponseDTO
{
    /**
     * @param array<string, mixed>|null $config
     */
    public function __construct(
        public int $idSerie,
        public int $idEmisor,
        public int $idPlantilla,
        public string $serie,
        public int $rangoInicial,
        public ?string $logo,
        public string $fecha,
        public int $tipo,
        public ?array $config,
        public ?string $status,
        public string $version,
        public ?string $estiloConceptos,
        public ?string $estiloTotales,
        public int $decimales,
        public string $rfcEmisor,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        // Support both API response formats (snake_case and UPPERCASE)
        $idSerie = $data['id_serie'] ?? $data['IDSERIE'] ?? null;
        $idEmisor = $data['id_emisor'] ?? $data['IDEMISOR'] ?? null;
        $idPlantilla = $data['id_plantilla'] ?? $data['IDPLANTILLA'] ?? null;
        $serie = $data['serie'] ?? $data['SERIE'] ?? null;
        $rangoInicial = $data['rango_inicial'] ?? $data['RANGOINICIAL'] ?? null;
        $logo = $data['logo_base64'] ?? $data['LOGO_BASE64'] ?? null;
        $fecha = $data['fecha'] ?? $data['FECHA'] ?? null;
        $tipo = $data['tipo'] ?? $data['TIPO'] ?? 1;
        $config = $data['config'] ?? $data['CONFIG'] ?? null;
        $status = $data['status'] ?? $data['STATUS'] ?? null;
        $version = $data['version'] ?? $data['VERSION'] ?? '2';
        $estiloConceptos = $data['estilo_conceptos'] ?? $data['ESTILOCONCEPTOS'] ?? null;
        $estiloTotales = $data['estilo_totales'] ?? $data['ESTILOTOTALES'] ?? null;
        $decimales = $data['decimales'] ?? $data['DECIMALES'] ?? 2;
        $rfcEmisor = $data['rfc_emisor'] ?? $data['RFCEMISOR'] ?? null;

        if ($serie === null) {
            throw new InvalidArgumentException(
                'Serie response must contain serie name',
            );
        }

        return new self(
            idSerie: self::toInt($idSerie, 0),
            idEmisor: self::toInt($idEmisor, 0),
            idPlantilla: self::toInt($idPlantilla, 0),
            serie: self::toString($serie),
            rangoInicial: self::toInt($rangoInicial, 1),
            logo: self::toNullableString($logo),
            fecha: self::toString($fecha),
            tipo: self::toInt($tipo, 1),
            config: self::toArrayMap($config),
            status: self::toNullableString($status),
            version: self::toString($version),
            estiloConceptos: self::toNullableString($estiloConceptos),
            estiloTotales: self::toNullableString($estiloTotales),
            decimales: self::toInt($decimales, 2),
            rfcEmisor: self::toString($rfcEmisor),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id_serie' => $this->idSerie,
            'id_emisor' => $this->idEmisor,
            'id_plantilla' => $this->idPlantilla,
            'serie' => $this->serie,
            'rango_inicial' => $this->rangoInicial,
            'logo' => $this->logo,
            'fecha' => $this->fecha,
            'tipo' => $this->tipo,
            'config' => $this->config,
            'status' => $this->status,
            'version' => $this->version,
            'estilo_conceptos' => $this->estiloConceptos,
            'estilo_totales' => $this->estiloTotales,
            'decimales' => $this->decimales,
            'rfc_emisor' => $this->rfcEmisor,
        ];
    }

    private static function toInt(mixed $value, int $default): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value)) {
            $filtered = filter_var($value, FILTER_VALIDATE_INT);

            return $filtered !== false ? $filtered : $default;
        }

        return $default;
    }

    private static function toString(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }

    private static function toNullableString(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }

    /**
     * @return array<string, mixed>|null
     */
    private static function toArrayMap(mixed $value): ?array
    {
        if (!is_array($value)) {
            return null;
        }

        /** @var array<string, mixed> $result */
        $result = $value;

        return $result;
    }
}
