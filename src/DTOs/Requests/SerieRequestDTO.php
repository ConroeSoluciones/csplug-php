<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use InvalidArgumentException;
use JsonSerializable;
use Override;

use function in_array;

/**
 * DTO for creating/updating a Serie.
 */
final class SerieRequestDTO implements JsonSerializable
{
    public const string VERSION_CFDI = 'CFDI';
    public const string VERSION_RETENCIONES = 'RETENCIONES';

    public const string TIPO_COMPROBANTE_INGRESO = 'I';
    public const string TIPO_COMPROBANTE_EGRESO = 'E';
    public const string TIPO_COMPROBANTE_NOMINA = 'N';
    public const string TIPO_COMPROBANTE_PAGO = 'P';

    public const array VERSIONES_COMPROBANTE = [self::VERSION_CFDI, self::VERSION_RETENCIONES];
    public const array TIPOS_COMPROBANTES = [
        self::TIPO_COMPROBANTE_INGRESO,
        self::TIPO_COMPROBANTE_EGRESO,
        self::TIPO_COMPROBANTE_NOMINA,
        self::TIPO_COMPROBANTE_PAGO,
    ];

    private ?string $serie = null;
    private ?string $version = null;
    private ?string $tipo = null;
    private ?string $clavePlantilla = null;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $config = null;
    private ?int $rangoInicial = null;

    /**
     * Series name (unique per RFC).
     */
    public function withSerie(string $serie): self
    {
        if ($serie === '') {
            throw new InvalidArgumentException('Series name cannot be empty');
        }
        $this->serie = $serie;

        return $this;
    }

    /**
     * Version: CFDI or RETENCIONES.
     */
    public function withVersion(string $version): self
    {
        if (!in_array($version, self::VERSIONES_COMPROBANTE, true)) {
            throw new InvalidArgumentException('Version must be CFDI or RETENCIONES');
        }
        $this->version = $version;

        return $this;
    }

    /**
     * Document type: I (Ingreso), E (Egreso), N (Nomina), P (Pago).
     * Optional but required for CFDI.
     */
    public function withTipo(string $tipo): self
    {
        if (!in_array($tipo, self::TIPOS_COMPROBANTES, true)) {
            throw new InvalidArgumentException('Tipo must be I (Ingreso), E (Egreso), N (Nomina), or P (Pago)');
        }
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Template ID (required, e.g. "default" for the default template).
     */
    public function withClavePlantilla(string $clavePlantilla): self
    {
        $this->clavePlantilla = $clavePlantilla;

        return $this;
    }

    public function withRangoInicial(int $rangoInicial): self
    {
        $this->rangoInicial = $rangoInicial;

        return $this;
    }

    /**
     * Optional configuration.
     *
     * @param array<string, mixed> $config
     */
    public function withConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Build and validate the DTO.
     */
    public function build(): self
    {
        if ($this->serie === null || $this->version === null) {
            throw new InvalidArgumentException(
                'Series name and version are required',
            );
        }

        if ($this->version === self::VERSION_CFDI && $this->tipo === null) {
            throw new InvalidArgumentException(
                'Tipo is required for CFDI series',
            );
        }

        if ($this->rangoInicial === null) {
            throw new InvalidArgumentException(
                'RangoInicial is required for series',
            );
        }

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $this->build();

        $data = [
            'serie' => $this->serie,
            'tipo_documento' => $this->version,
            'rango_inicial' => $this->rangoInicial,
        ];

        if ($this->tipo !== null) {
            $data['tipo_comprobante'] = $this->tipo;
        }

        if ($this->clavePlantilla !== null) {
            $data['id_plantilla'] = $this->clavePlantilla;
        }

        if ($this->config !== null) {
            $data['config'] = $this->config;
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    public function getSerie(): ?string
    {
        return $this->serie ?? null;
    }

    public function getVersion(): ?string
    {
        return $this->version ?? null;
    }

    public function getTipo(): ?string
    {
        return $this->tipo ?? null;
    }

    public function getClavePlantilla(): ?string
    {
        return $this->clavePlantilla ?? null;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }
}
