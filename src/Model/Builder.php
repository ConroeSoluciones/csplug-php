<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use LogicException;

abstract class Builder
{
    /**
     * @var string[] $requiredFields
     * List of required fields for the builder, to be validated before building the object
     */
    protected array $requiredFields = [];

    public function validate(): void
    {
        foreach ($this->requiredFields as $field) {
            if ($this->$field === null || $this->$field === '') {
                throw new LogicException("$field no puede ser null o vacio!");
            }
        }
    }

    abstract public function build(): Buildable;
}
