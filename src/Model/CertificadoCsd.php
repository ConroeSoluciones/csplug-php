<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

final class CertificadoCsd implements \JsonSerializable
{
    private string $cer;
    private string $key;
    private string $password;

    public function __construct(CertificadoCsdBuilder $builder)
    {
        $this->cer = $builder->getCer();
        $this->key = $builder->getKey();
        $this->password = $builder->getPassword();
    }

    public function getCer(): string
    {
        return $this->cer;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function jsonSerialize(): array
    {
        // Serialization casing matches requirement: key, cer, password (based on typical JSON API needs, user provided example was lowercase)
        return [
            'cer' => $this->getCer(),
            'key' => $this->getKey(),
            'password' => $this->getPassword(),
        ];
    }
}
