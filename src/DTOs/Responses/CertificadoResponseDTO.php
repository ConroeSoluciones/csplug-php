<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use InvalidArgumentException;

use function filter_var;
use function is_int;
use function is_string;

use const FILTER_VALIDATE_INT;

/**
 * Response DTO for a certificate (CSD).
 */
final readonly class CertificadoResponseDTO
{
    public function __construct(
        public int $idCertSello,
        public ?int $idEmisor,
        public string $cer,
        public string $serieCertificado,
        public string $inicioVigencia,
        public string $finVigencia,
        public string $passwordKey,
        public string $pem,
        public string $fecha,
        public int $tipo,
        public int $tipoCertificado,
        public ?string $status,
        public ?string $url,
        public string $fechaInicial,
        public string $fechaFinal,
        public string $rfcEmisor,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        // Support both API response formats (snake_case and lowercase/UPPERCASE)
        $idCertSello = $data['id_cert_sello'] ?? $data['ID_CERT_SELLO'] ?? null;
        $idEmisor = $data['id_emisor'] ?? $data['ID_EMISOR'] ?? null;
        $cer = $data['cer'] ?? $data['CER'] ?? null;
        $serieCertificado = $data['serie_certificado'] ?? $data['SERIE_CERTIFICADO'] ?? null;
        $inicioVigencia = $data['inicio_vigencia'] ?? $data['INICIO_VIGENCIA'] ?? null;
        $finVigencia = $data['fin_vigencia'] ?? $data['FIN_VIGENCIA'] ?? null;
        $passwordKey = $data['password_key'] ?? $data['PASSWORD_KEY'] ?? null;
        $pem = $data['pem'] ?? $data['PEM'] ?? null;
        $fecha = $data['fecha'] ?? $data['FECHA'] ?? null;
        $tipo = $data['tipo'] ?? $data['TIPO'] ?? 0;
        $tipoCertificado = $data['tipo_certificado'] ?? $data['TIPO_CERTIFICADO'] ?? 0;
        $status = $data['status'] ?? $data['STATUS'] ?? null;
        $url = $data['url'] ?? $data['URL'] ?? null;
        $fechaInicial = $data['fecha_inicial'] ?? $data['FECHA_INICIAL'] ?? null;
        $fechaFinal = $data['fecha_final'] ?? $data['FECHA_FINAL'] ?? null;
        $rfcEmisor = $data['rfc_emisor'] ?? $data['RFC_EMISOR'] ?? null;

        if ($cer === null || $serieCertificado === null) {
            throw new InvalidArgumentException(
                'Certificate response must contain cer and serie_certificado',
            );
        }

        return new self(
            idCertSello: self::toInt($idCertSello, 0),
            idEmisor: self::toNullableInt($idEmisor),
            cer: self::toString($cer),
            serieCertificado: self::toString($serieCertificado),
            inicioVigencia: self::toString($inicioVigencia),
            finVigencia: self::toString($finVigencia),
            passwordKey: self::toString($passwordKey),
            pem: self::toString($pem),
            fecha: self::toString($fecha),
            tipo: self::toInt($tipo, 0),
            tipoCertificado: self::toInt($tipoCertificado, 0),
            status: self::toNullableString($status),
            url: self::toNullableString($url),
            fechaInicial: self::toString($fechaInicial),
            fechaFinal: self::toString($fechaFinal),
            rfcEmisor: self::toString($rfcEmisor),
        );
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

    private static function toNullableInt(mixed $value): ?int
    {
        if ($value === null) {
            return null;
        }

        return self::toInt($value, 0);
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
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id_cert_sello' => $this->idCertSello,
            'id_emisor' => $this->idEmisor,
            'cer' => $this->cer,
            'serie_certificado' => $this->serieCertificado,
            'inicio_vigencia' => $this->inicioVigencia,
            'fin_vigencia' => $this->finVigencia,
            'password_key' => $this->passwordKey,
            'pem' => $this->pem,
            'fecha' => $this->fecha,
            'tipo' => $this->tipo,
            'tipo_certificado' => $this->tipoCertificado,
            'status' => $this->status,
            'url' => $this->url,
            'fecha_inicial' => $this->fechaInicial,
            'fecha_final' => $this->fechaFinal,
            'rfc_emisor' => $this->rfcEmisor,
        ];
    }
}
