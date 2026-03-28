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
    public const VERSION_CFDI = 2;
    public const VERSION_RETENCIONES = 3;

    public const TIPO_USO_GENERAL = 1;
    public const TIPO_NOMINA = 2;
    public const TIPO_PAGOS = 3;

    private ?string $serie = null;
    private ?int $version = null;
    private ?int $tipo = null;
    private ?int $idPlantilla = null;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $config = null;

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
     * Version: 2 for CFDI, 3 for Retenciones.
     */
    public function withVersion(int $version): self
    {
        if (!in_array($version, [self::VERSION_CFDI, self::VERSION_RETENCIONES], true)) {
            throw new InvalidArgumentException('Version must be 2 (CFDI) or 3 (Retenciones)');
        }
        $this->version = $version;

        return $this;
    }

    /**
     * Document type: 1=General, 2=Nomina, 3=Pagos.
     * Optional but required for CFDI.
     */
    public function withTipo(int $tipo): self
    {
        if (!in_array($tipo, [self::TIPO_USO_GENERAL, self::TIPO_NOMINA, self::TIPO_PAGOS], true)) {
            throw new InvalidArgumentException('Tipo must be 1 (General), 2 (Nomina), or 3 (Pagos)');
        }
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Template ID (required, usually 78 for "Default").
     */
    public function withIdPlantilla(int $idPlantilla): self
    {
        $this->idPlantilla = $idPlantilla;

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

        // Tipo is required for CFDI (version 2)
        if ($this->version === self::VERSION_CFDI && $this->tipo === null) {
            throw new InvalidArgumentException(
                'Tipo is required for CFDI series (version 2)',
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
            'version' => $this->version,
        ];

        if ($this->tipo !== null) {
            $data['tipo'] = $this->tipo;
        }

        if ($this->idPlantilla !== null) {
            $data['id_plantilla'] = $this->idPlantilla;
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
        return $this->serie;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function getIdPlantilla(): ?int
    {
        return $this->idPlantilla;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }
}
