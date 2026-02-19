<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use function json_decode;

final class EmisorHijo implements Deserializable, \JsonSerializable
{
    private Rfc $rfc;
    private string $razonSocial;
    private string $domicilioFiscal;
    private ?EmisorHijoConfiguracion $configuracion;
    public function __construct(EmisorHijoBuilder $builder) {
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
     * @throws \JsonException
     */
    public static function fromJson(string $raw): array|self
    {
        $data = (array) json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        $isList = array_is_list($data);
        $dataList = $isList ? $data : [$data];
        /** @var $models EmisorHijo[] */
        $models = [];

        /**
         * @var array<string, mixed> $meta
         * @psalm-suppress MixedArgument
         */
        foreach ($dataList as $meta) {
            /** @psalm-suppress ArgumentTypeCoercion */
            $models[] = self::fromArray($meta); // @phpstan-ignore argument.type
        }

        return $isList ? $models : $models[0];
    }

    public static function fromArray(array $data): self{
        return (new EmisorHijoBuilder())
            ->withRfc(new Rfc($data['RFC']))
            ->withRazonSocial($data['RAZONSOCIAL'])
            ->withDomicilioFiscal($data['DOMICILIOFISCAL'])
            ->withConfiguracion( new EmisorHijoConfiguracion(
                calle: $data['CONFIGURACION']['CALLE'] ?? '',
                numero_exterior: $data['CONFIGURACION']['NEXT'] ?? '',
                numero_interior: $data['CONFIGURACION']['NINT'] ?? '',
                colonia: $data['CONFIGURACION']['COLONIA'] ?? '',
                localidad: $data['CONFIGURACION']['LOCALIDAD'] ?? '',
                municipio: $data['CONFIGURACION']['MUNICIPIO'] ?? '',
                estado: $data['CONFIGURACION']['ESTADO'] ?? '',
                pais: $data['CONFIGURACION']['PAIS'] ?? '',
            ))
            ->build();
    }

    public function jsonSerialize(): array
    {
        $data = [
            'rfc' => $this->getRfc(),
            'razon_social' => $this->getRazonSocial(),
            'domicilio_fiscal' => $this->getDomicilioFiscal(),
        ];

        if($this->getConfiguracion())
            $data['configuracion'] = $this->getConfiguracion();

        return $data;
    }
}
