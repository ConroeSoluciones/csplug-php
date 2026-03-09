<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

interface Deserializable
{
    /**
     * @return array|string[]|self $raw
     */
    public static function fromJson(string $raw): array | self;
}
