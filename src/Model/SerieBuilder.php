<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

class SerieBuilder
{
    private string $serie;
    private int $rangoInicial;
    private int $cantidadDecimales = 2;
    private string $tipoComprobante = 'INGRESO';
    private string $tipoDocumento = 'CFDI';
    private ?string $logo = null;
    private ?int $plantillaId = null;

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

    public function withCantidadDecimales(int $cantidadDecimales): self
    {
        $this->cantidadDecimales = $cantidadDecimales;
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

    public function withLogo(string $logo): self
    {
        $this->logo = $logo;
        return $this;
    }

    public function withPlantillaId(int $plantillaId): self
    {
        $this->plantillaId = $plantillaId;
        return $this;
    }

    public function build(): Serie
    {
        if (!isset($this->serie)) {
             throw new \RuntimeException('La serie es requerida.');
        }
        if (!isset($this->rangoInicial)) {
             throw new \RuntimeException('El rango inicial es requerido.');
        }

        return new Serie(
            serie: $this->serie,
            rangoInicial: $this->rangoInicial,
            decimales: $this->cantidadDecimales,
            tipoComprobante: $this->tipoComprobante,
            tipoDocumento: $this->tipoDocumento,
            logo: $this->logo,
            plantillaId: $this->plantillaId
        );
    }
}
