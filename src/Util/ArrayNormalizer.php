<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use function is_array;
use function is_numeric;
use function is_string;

/**
 * Normalizador de payloads mixtos del API a tipos con llaves/elementos validados.
 */
final class ArrayNormalizer
{
    /**
     * Normaliza un valor mixto a un mapa `array<string, mixed>`.
     *
     * @return array<string, mixed>
     */
    public static function toMap(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }

        /** @var array<string, mixed> $map */
        $map = [];

        /**
         * El payload del API es mixto.
         *
         * @psalm-suppress MixedAssignment
         */
        foreach ($value as $key => $item) {
            $map[(string) $key] = $item;
        }

        return $map;
    }

    /**
     * Normaliza un valor mixto a una lista de mapas `list<array<string, mixed>>`.
     *
     * @return list<array<string, mixed>>
     */
    public static function toListOfMaps(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }

        $list = self::toMap($value);

        $normalized = [];

        /**
         * El payload del API es mixto.
         *
         * @psalm-suppress MixedAssignment
         */
        foreach ($list as $item) {
            $normalized[] = self::toMap($item);
        }

        return $normalized;
    }

    public static function toNullableString(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }

    /**
     * Normaliza un valor mixto a una lista de mapas o `null` si esta vacía.
     *
     * @return list<array<string, mixed>>|null
     */
    public static function toListOfMapsOrNull(mixed $value): ?array
    {
        $list = self::toListOfMaps($value);

        return $list !== [] ? $list : null;
    }

    public static function toString(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }

    public static function toNullableFloat(mixed $value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
    }
}
