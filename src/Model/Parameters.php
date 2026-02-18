<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

class Parameters implements \JsonSerializable
{
    private ?array $queryParams;
    private Builder|array|\JsonSerializable|null $entity;

    public function __construct(ParametersBuilder $builder){
        $this->queryParams = $builder->getqueryParams();
        $this->entity = $builder->getEntity();
    }

    public function getQueryParams(): ?array
    {
        return $this->queryParams;
    }

    public function getEntity(): Builder|array|\JsonSerializable|null
    {
        return $this->entity;
    }

    public function jsonSerialize(): array
    {
        if(!$this->entity) return [];

        return $this->entity instanceof \JsonSerializable ? $this->entity->jsonSerialize() : $this->entity;
    }


}