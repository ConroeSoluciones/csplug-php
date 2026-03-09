<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use JsonSerializable;
use Override;
use RuntimeException;

final readonly class EmisorHijoConfiguracion implements Buildable, Deserializable, JsonSerializable
{
    public function __construct(
        private ?string $calle = null,
        private ?string $numeroExterior = null,
        private ?string $numeroInterior = null,
        private ?string $colonia = null,
        private ?string $localidad = null,
        private ?string $municipio = null,
        private ?string $estado = null,
        private ?string $pais = null,
    ) {
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function getNumeroExterior(): ?string
    {
        return $this->numeroExterior;
    }

    public function getNumeroInterior(): ?string
    {
        return $this->numeroInterior;
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

    #[Override]
    public static function fromJson(string $raw): Deserializable
    {
        throw new RuntimeException('Not implemented: use EmisorHijo::fromJson() instead.');
    }

    /**
     * @return (string|null)[]
     *
     * @psalm-return array{calle: string|null, numero_exterior: string|null, numero_interior: string|null, colonia: string|null, localidad: string|null, municipio: string|null, estado: string|null, pais: string|null}
     */
    public function toArray(): array
    {
        return [
            'calle' => $this->calle,
            'numero_exterior' => $this->numeroExterior,
            'numero_interior' => $this->numeroInterior,
            'colonia' => $this->colonia,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'estado' => $this->estado,
            'pais' => $this->pais,
        ];
    }

    /**
     * @return (string|null)[]
     *
     * @psalm-return array{calle: string|null, numero_exterior: string|null, numero_interior: string|null, colonia: string|null, localidad: string|null, municipio: string|null, estado: string|null, pais: string|null}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'calle' => $this->calle,
            'numero_exterior' => $this->numeroExterior,
            'numero_interior' => $this->numeroInterior,
            'colonia' => $this->colonia,
            'localidad' => $this->localidad,
            'municipio' => $this->municipio,
            'estado' => $this->estado,
            'pais' => $this->pais,
        ];
    }
}
