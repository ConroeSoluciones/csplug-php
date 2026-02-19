<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use LogicException;

/**
 * Builder instance for {@see CertificadoCsd}
 */
class CertificadoCsdBuilder extends Builder
{
    private ?string $cer;
    private ?string $key;
    private ?string $password;

    protected array $requiredFields = [
        'cer', 'key', 'password'
    ];

    public function withCer(string $cer): self
    {
        $this->cer = $cer;
        return $this;
    }

    public function withKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function validate(): void
    {
        parent::validate();
    }

    public function build(): CertificadoCsd{
        $this->validate();
        return new CertificadoCsd($this);
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
}
