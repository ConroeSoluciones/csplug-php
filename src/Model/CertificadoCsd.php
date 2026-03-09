<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use JsonSerializable;
use Override;

final class CertificadoCsd implements Buildable, JsonSerializable
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

    public static function builder(): CertificadoCsdBuilder
    {
        return new CertificadoCsdBuilder();
    }

    /**
     * Serialize the object to a value that can be serialized natively by json_encode().
     *
     * @return string[]
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'cer' => $this->getCer(),
            'key' => $this->getKey(),
            'password' => $this->getPassword(),
        ];
    }
}
