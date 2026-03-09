<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use InvalidArgumentException;
use JsonSerializable;
use Override;

use function preg_match;

final class Rfc implements JsonSerializable
{
    public function __construct(private readonly string $value)
    {
        if (
            preg_match(
                '#[A-Z&Ñ]{3,4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]#',
                $this->value,
            ) === false
        ) {
            throw new InvalidArgumentException('Valor de RFC invalido');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
