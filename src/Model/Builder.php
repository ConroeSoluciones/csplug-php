<?php

namespace Csfacturacion\CsPlug\Model;

abstract class Builder
{
    private array $requiredFields = [];
    
    public function validate(){
        foreach ($this->requiredFields as $field) {
            if ($this->$field === null || $this->$field === '') {
                throw new LogicException("$field no puede ser null o vacio!");
            }
        }
    }
    abstract public function build();
}