<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use Csfacturacion\CsPlug\Util\ArrayNormalizer;

use function is_int;
use function is_numeric;

/**
 * Concepto de un CFDI.
 */
final readonly class CfdiConceptoDTO
{
    /**
     * @param list<array<string, mixed>>|null $impuestos
     * @param array<string, mixed>|null $aCuentaTerceros
     */
    public function __construct(
        public ?int $id,
        public ?string $identificacion,
        public ?string $cantidad,
        public ?string $unidad,
        public ?string $claveUnidad,
        public ?string $claveProdServ,
        public ?string $descripcion,
        public ?string $precio,
        public ?string $precioBase,
        public ?string $descuento,
        public ?string $objetoImp,
        public ?array $impuestos,
        public ?array $aCuentaTerceros,
    ) {
    }

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $aCuentaTerceros = ArrayNormalizer::toMap($data['a_cuenta_terceros'] ?? null);
        $impuestos = ArrayNormalizer::toListOfMaps($data['impuestos'] ?? null);

        return new self(
            id: self::toNullableInt($data['id'] ?? null),
            identificacion: ArrayNormalizer::toNullableString($data['identificacion'] ?? null),
            cantidad: ArrayNormalizer::toNullableString($data['cantidad'] ?? null),
            unidad: ArrayNormalizer::toNullableString($data['unidad'] ?? null),
            claveUnidad: ArrayNormalizer::toNullableString($data['clave_unidad'] ?? null),
            claveProdServ: ArrayNormalizer::toNullableString($data['clave_prod_serv'] ?? null),
            descripcion: ArrayNormalizer::toNullableString($data['descripcion'] ?? null),
            precio: ArrayNormalizer::toNullableString($data['precio'] ?? null),
            precioBase: ArrayNormalizer::toNullableString($data['precio_base'] ?? null),
            descuento: ArrayNormalizer::toNullableString($data['descuento'] ?? null),
            objetoImp: ArrayNormalizer::toNullableString($data['objeto_imp'] ?? null),
            impuestos: $impuestos !== [] ? $impuestos : null,
            aCuentaTerceros: $aCuentaTerceros !== [] ? $aCuentaTerceros : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'identificacion' => $this->identificacion,
            'cantidad' => $this->cantidad,
            'unidad' => $this->unidad,
            'clave_unidad' => $this->claveUnidad,
            'clave_prod_serv' => $this->claveProdServ,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'precio_base' => $this->precioBase,
            'descuento' => $this->descuento,
            'objeto_imp' => $this->objetoImp,
            'impuestos' => $this->impuestos,
            'a_cuenta_terceros' => $this->aCuentaTerceros,
        ];
    }

    private static function toNullableInt(mixed $value): ?int
    {
        if (is_int($value)) {
            return $value;
        }

        return is_numeric($value) ? (int) $value : null;
    }
}
