<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use InvalidArgumentException;
use JsonSerializable;
use Override;

use function json_decode;

use const JSON_THROW_ON_ERROR;

final readonly class Serie implements Buildable, Deserializable, JsonSerializable
{
    private ?int $idSerie;
    private ?string $serie;
    private ?int $rangoInicial;
    private ?string $fecha;
    private ?int $decimales;
    private ?string $rfcEmisor;
    private ?string $tipoComprobante;
    private ?string $tipoDocumento;
    private ?int $idEmisor;
    private ?int $idPlantilla;
    private ?string $logo;
    private ?string $config;
    private ?int $estatus;
    private ?int $version;
    private ?string $estiloConceptos;
    private ?string $estiloTotales;

    public function __construct(SerieBuilder $builder)
    {
        $this->idSerie = $builder->getIdSerie();
        $this->serie = $builder->getSerie();
        $this->rangoInicial = $builder->getRangoInicial();
        $this->fecha = $builder->getFecha();
        $this->decimales = $builder->getDecimales();
        $this->rfcEmisor = $builder->getRfcEmisor();
        $this->tipoComprobante = $builder->getTipoComprobante();
        $this->tipoDocumento = $builder->getTipoDocumento();
        $this->idEmisor = $builder->getIdEmisor();
        $this->idPlantilla = $builder->getIdPlantilla();
        $this->logo = $builder->getLogo();
        $this->config = $builder->getConfig();
        $this->estatus = $builder->getEstatus();
        $this->version = $builder->getVersion();
        $this->estiloConceptos = $builder->getEstiloConceptos();
        $this->estiloTotales = $builder->getEstiloTotales();
    }

    public static function builder(): SerieBuilder
    {
        return new SerieBuilder();
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $builder = self::builder()
            ->withIdSerie((int) $data['IDSERIE']) // @phpstan-ignore cast.int
            ->withSerie((string) $data['SERIE']) // @phpstan-ignore cast.string
            ->withRangoInicial((int) $data['RANGOINICIAL']) // @phpstan-ignore cast.int
            ->withFecha((string) $data['FECHA']) // @phpstan-ignore cast.string
            ->withDecimales((int) $data['DECIMALES']); // @phpstan-ignore cast.int

        if (isset($data['RFCEMISOR'])) {
            $builder->withRfcEmisor((string) $data['RFCEMISOR']); // @phpstan-ignore cast.string
        }

        if (isset($data['TIPOCOMPROBANTE'])) {
            $builder->withTipoComprobante((string) $data['TIPOCOMPROBANTE']); // @phpstan-ignore cast.string
        }

        if (isset($data['TIPO'])) {
            $builder->withTipoDocumento((string) $data['TIPO']); // @phpstan-ignore cast.string
        }

        if (isset($data['IDEMISOR'])) {
            $builder->withIdEmisor((int) $data['IDEMISOR']); // @phpstan-ignore cast.int
        }

        if (isset($data['IDPLANTILLA'])) {
            $builder->withPlantilla((int) $data['IDPLANTILLA']); // @phpstan-ignore cast.int
        }

        if (isset($data['RUTALOGO'])) {
            $builder->withLogo((string) $data['RUTALOGO']); // @phpstan-ignore cast.string
        }

        if (isset($data['CONFIG'])) {
            $builder->withConfig((string) $data['CONFIG']); // @phpstan-ignore cast.string
        }

        if (isset($data['ESTATUS'])) {
            $builder->withEstatus((int) $data['ESTATUS']); // @phpstan-ignore cast.int
        }

        if (isset($data['VERSION'])) {
            $builder->withVersion((int) $data['VERSION']); // @phpstan-ignore cast.int
        }

        if (isset($data['ESTILOCONCEPTOS'])) {
            $builder->withEstiloConceptos((string) $data['ESTILOCONCEPTOS']); // @phpstan-ignore cast.string
        }

        if (isset($data['ESTILOTOTALES'])) {
            $builder->withEstiloTotales((string) $data['ESTILOTOTALES']); // @phpstan-ignore cast.string
        }

        /** @var Serie $serie */
        $serie = $builder->build();

        return $serie;
    }

    #[Override]
    public static function fromJson(string $raw): self
    {
        /** @var array<string, mixed> $data */
        $data = (array) json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        return self::fromArray($data);
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        if ($this->tipoComprobante === null || $this->tipoDocumento === null) {
            throw new InvalidArgumentException(
                'Los campos tipo_comprobante y tipo_documento son obligatorios para la serialización JSON.',
            );
        }

        $data = [
            'serie' => $this->serie,
            'rango_inicial' => $this->rangoInicial,
            'cantidad_decimales' => $this->decimales,
            'tipo_comprobante' => $this->tipoComprobante,
            'tipo_documento' => $this->tipoDocumento,
        ];

        if ($this->logo !== null) {
            $data['logo'] = $this->logo;
        }

        if ($this->idPlantilla !== null) {
            $data['plantilla_id'] = $this->idPlantilla;
        }

        return $data;
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
