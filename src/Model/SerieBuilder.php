<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Override;

/**
 * Builder instance for {@see Serie}
 */
final class SerieBuilder extends Builder
{
    protected ?int $idSerie = null;
    protected ?string $serie = null;
    protected ?int $rangoInicial = null;
    protected ?string $fecha = null;
    protected ?int $decimales = null;
    protected ?string $rfcEmisor = null;
    protected ?string $tipoComprobante = null;
    protected ?string $tipoDocumento = null;
    protected ?int $idEmisor = null;
    protected ?int $idPlantilla = null;
    protected ?string $logo = null;
    protected ?string $config = null;
    protected ?int $estatus = null;
    protected ?int $version = null;
    protected ?string $estiloConceptos = null;
    protected ?string $estiloTotales = null;

    /** @var string[] */
    protected array $requiredFields = [
        'serie', 'rangoInicial', 'decimales', 'tipoComprobante', 'tipoDocumento',
    ];

    public function withIdSerie(int $idSerie): self
    {
        $this->idSerie = $idSerie;

        return $this;
    }

    public function withSerie(string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function withRangoInicial(int $rangoInicial): self
    {
        $this->rangoInicial = $rangoInicial;

        return $this;
    }

    public function withFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function withDecimales(int $decimales): self
    {
        $this->decimales = $decimales;

        return $this;
    }

    public function withRfcEmisor(string $rfcEmisor): self
    {
        $this->rfcEmisor = $rfcEmisor;

        return $this;
    }

    public function withTipoComprobante(string $tipoComprobante): self
    {
        $this->tipoComprobante = $tipoComprobante;

        return $this;
    }

    public function withTipoDocumento(string $tipoDocumento): self
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    public function withIdEmisor(int $idEmisor): self
    {
        $this->idEmisor = $idEmisor;

        return $this;
    }

    public function withPlantilla(int $idPlantilla): self
    {
        $this->idPlantilla = $idPlantilla;

        return $this;
    }

    public function withLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function withConfig(string $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function withEstatus(int $estatus): self
    {
        $this->estatus = $estatus;

        return $this;
    }

    public function withVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function withEstiloConceptos(string $estiloConceptos): self
    {
        $this->estiloConceptos = $estiloConceptos;

        return $this;
    }

    public function withEstiloTotales(string $estiloTotales): self
    {
        $this->estiloTotales = $estiloTotales;

        return $this;
    }

    #[Override]
    public function build(): Serie
    {
        $this->validate();

        return new Serie($this);
    }

    public function getIdSerie(): ?int
    {
        return $this->idSerie;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function getRangoInicial(): ?int
    {
        return $this->rangoInicial;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function getDecimales(): ?int
    {
        return $this->decimales;
    }

    public function getRfcEmisor(): ?string
    {
        return $this->rfcEmisor;
    }

    public function getTipoComprobante(): ?string
    {
        return $this->tipoComprobante;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipoDocumento;
    }

    public function getIdEmisor(): ?int
    {
        return $this->idEmisor;
    }

    public function getIdPlantilla(): ?int
    {
        return $this->idPlantilla;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function getConfig(): ?string
    {
        return $this->config;
    }

    public function getEstatus(): ?int
    {
        return $this->estatus;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getEstiloConceptos(): ?string
    {
        return $this->estiloConceptos;
    }

    public function getEstiloTotales(): ?string
    {
        return $this->estiloTotales;
    }
}
