<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use function PHPUnit\Framework\isNumeric;

class ParametersBuilder implements Builder
{
    private ?array $queryParams;
    private Builder|array|\JsonSerializable|null $entity = null;

    public function validate(): void
    {
        if($this->entity instanceof Builder) $this->entity->validate();
    }

    public function build(): Parameters
    {
        $this->validate();

        return new Parameters($this);
    }

    public function getQueryParams(): ?array
    {
        return $this->queryParams;
    }

    public function getEntity(): Builder|array|\JsonSerializable|null
    {
        return $this->entity;
    }

    public function withQueryParams(array $queryParams): self{
        $this->queryParams = $queryParams;

        return $this;
    }

    public function withEntity(Builder|array|\JsonSerializable $entity): self{
        $this->entity = $entity;

        return $this;
    }
}