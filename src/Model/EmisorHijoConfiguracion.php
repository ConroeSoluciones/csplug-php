<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;

final class EmisorHijoConfiguracion implements Deserializable, \JsonSerializable
{
    public function __construct(
        private readonly ?string $calle = null,
        private readonly ?string $numero_exterior = null,
        private readonly ?string $numero_interior = null,
        private readonly ?string $colonia = null,
        private readonly ?string $localidad = null,
        private readonly ?string $municipio = null,
        private readonly ?string $estado = null,
        private readonly ?string $pais = null,
    )
    {}

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function getNumeroExterior(): ?string
    {
        return $this->numero_exterior;
    }

    public function getNumeroInterior(): ?string
    {
        return $this->numero_interior;
    }

    public function getColonia(): ?string
    {
        return $this->colonia;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function getMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public static function fromJson(string $json): Deserializable
    {

    }

    public function toArray():array{
        return [
            'calle' => $this->calle,
            'numero_exterior' => $this->numero_exterior,
            'numero_interior' => $this->numero_interior,
            'colonia' => $this->colonia,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'estado' => $this->estado,
            'pais' => $this->pais,
        ];
    }

    public function jsonSerialize(): array
    {
        return [
            'calle' => $this->calle,
            'numero_exterior' => $this->numero_exterior,
            'numero_interior' => $this->numero_interior,
            'colonia' => $this->colonia,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'estado' => $this->estado,
            'pais' => $this->pais,
        ];
    }
}