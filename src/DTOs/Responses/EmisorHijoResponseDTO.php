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
 * Response DTO for a single EmisorHijo.
 */
final readonly class EmisorHijoResponseDTO
{
    /**
     * @param array<string, mixed>|null $configuracion
     */
    public function __construct(
        public int $idEmisorHijo,
        public int $idEmisor,
        public string $rfc,
        public ?string $identificacion,
        public string $razonSocial,
        public string $domicilioFiscal,
        public ?array $configuracion,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        // Support both API response formats (snake_case and UPPERCASE)
        $rfc = $data['rfc'] ?? $data['RFC'] ?? null;
        $razonSocial = $data['razon_social'] ?? $data['RAZONSOCIAL'] ?? null;
        $domicilioFiscal = $data['domicilio_fiscal'] ?? $data['DOMICILIOFISCAL'] ?? null;
        $idEmisorHijo = $data['id_emisor_hijo'] ?? $data['ID_EMISOR_HIJO'] ?? null;
        $idEmisor = $data['id_emisor'] ?? $data['ID_EMISOR'] ?? null;
        $identificacion = $data['identificacion'] ?? $data['IDENTIFICACION'] ?? null;
        $configuracion = $data['configuracion'] ?? $data['CONFIGURACION'] ?? null;

        if ($rfc === null || $razonSocial === null || $domicilioFiscal === null) {
            throw new InvalidArgumentException(
                'EmisorHijo response must contain rfc, razon_social, and domicilio_fiscal',
            );
        }

        return new self(
            idEmisorHijo: self::toInt($idEmisorHijo, 0),
            idEmisor: self::toInt($idEmisor, 0),
            rfc: self::toString($rfc),
            identificacion: self::toNullableString($identificacion),
            razonSocial: self::toString($razonSocial),
            domicilioFiscal: self::toString($domicilioFiscal),
            configuracion: self::toArrayMap($configuracion),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id_emisor_hijo' => $this->idEmisorHijo,
            'id_emisor' => $this->idEmisor,
            'rfc' => $this->rfc,
            'identificacion' => $this->identificacion,
            'razon_social' => $this->razonSocial,
            'domicilio_fiscal' => $this->domicilioFiscal,
            'configuracion' => $this->configuracion,
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
