<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

interface Deserializable
{
    public static function fromJson(string $raw): array|self;
}
