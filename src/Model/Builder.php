<?php

namespace Csfacturacion\CsPlug\Model;

interface Builder
{
    public function validate();
    public function build();
}