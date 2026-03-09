<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use JsonException;
use JsonSerializable;
use Override;

use function array_is_list;
use function is_array;
use function is_string;
use function json_decode;

use const JSON_THROW_ON_ERROR;

final class EmisorHijo implements Buildable, Deserializable, JsonSerializable
{
    private Rfc $rfc;
    private string $razonSocial;
    private string $domicilioFiscal;
    private ?EmisorHijoConfiguracion $configuracion;

    public function __construct(EmisorHijoBuilder $builder)
    {
        $this->rfc = $builder->getRfc();
        $this->razonSocial = $builder->getRazonSocial();
        $this->domicilioFiscal = $builder->getDomicilioFiscal();
        $this->configuracion = $builder->getConfiguracion();
    }

    public function getRfc(): Rfc
    {
        return $this->rfc;
    }

    public function getRazonSocial(): string
    {
        return $this->razonSocial;
    }

    public function getDomicilioFiscal(): string
    {
        return $this->domicilioFiscal;
    }

    public function getConfiguracion(): ?EmisorHijoConfiguracion
    {
        return $this->configuracion ?? null;
    }

    /**
     * @return self|self[]
     *
     * @throws JsonException
     */
    #[Override]
    public static function fromJson(string $raw): array | self
    {
        $data = (array) json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        $isList = array_is_list($data);
        $dataList = $isList ? $data : [$data];
        /** @var EmisorHijo[] $models */
        $models = [];

        /**
         * @var array<string, mixed> $meta
         * @psalm-suppress MixedArgument
         */
        foreach ($dataList as $meta) {
            /** @psalm-suppress MixedArgument @var array<string, mixed> $meta */
            $models[] = self::fromArray($meta);
        }

        return $isList ? $models : $models[0];
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $rfc = isset($data['RFC']) && is_string($data['RFC']) ? $data['RFC'] : '';
        $razonSocial = isset($data['RAZONSOCIAL']) && is_string($data['RAZONSOCIAL']) ? $data['RAZONSOCIAL'] : '';
        $domicilioFiscal = isset($data['DOMICILIOFISCAL']) && is_string($data['DOMICILIOFISCAL'])
            ? $data['DOMICILIOFISCAL']
            : '';

        $configuracionRaw = isset($data['CONFIGURACION']) && is_array($data['CONFIGURACION'])
            ? $data['CONFIGURACION']
            : [];

        /** @var EmisorHijo $result */
        $result = (new EmisorHijoBuilder())
            ->withRfc(new Rfc($rfc))
            ->withRazonSocial($razonSocial)
            ->withDomicilioFiscal($domicilioFiscal)
            ->withConfiguracion(new EmisorHijoConfiguracion(
                calle: isset($configuracionRaw['CALLE']) && is_string($configuracionRaw['CALLE'])
                    ? $configuracionRaw['CALLE']
                    : null,
                numeroExterior: isset($configuracionRaw['NEXT']) && is_string($configuracionRaw['NEXT'])
                    ? $configuracionRaw['NEXT']
                    : null,
                numeroInterior: isset($configuracionRaw['NINT']) && is_string($configuracionRaw['NINT'])
                    ? $configuracionRaw['NINT']
                    : null,
                colonia: isset($configuracionRaw['COLONIA']) && is_string($configuracionRaw['COLONIA'])
                    ? $configuracionRaw['COLONIA']
                    : null,
                localidad: isset($configuracionRaw['LOCALIDAD']) && is_string($configuracionRaw['LOCALIDAD'])
                    ? $configuracionRaw['LOCALIDAD']
                    : null,
                municipio: isset($configuracionRaw['MUNICIPIO']) && is_string($configuracionRaw['MUNICIPIO'])
                    ? $configuracionRaw['MUNICIPIO']
                    : null,
                estado: isset($configuracionRaw['ESTADO']) && is_string($configuracionRaw['ESTADO'])
                    ? $configuracionRaw['ESTADO']
                    : null,
                pais: isset($configuracionRaw['PAIS']) && is_string($configuracionRaw['PAIS'])
                    ? $configuracionRaw['PAIS']
                    : null,
            ))
            ->build();

        return $result;
    }

    /**
     * @return (EmisorHijoConfiguracion|Rfc|string|null)[]
     *
     * @psalm-return array{rfc: Rfc, razon_social: string, domicilio_fiscal: string, configuracion?: EmisorHijoConfiguracion|null}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $data = [
            'rfc' => $this->getRfc(),
            'razon_social' => $this->getRazonSocial(),
            'domicilio_fiscal' => $this->getDomicilioFiscal(),
        ];

        if ($this->getConfiguracion()) {
            $data['configuracion'] = $this->getConfiguracion();
        }

        return $data;
    }
}
