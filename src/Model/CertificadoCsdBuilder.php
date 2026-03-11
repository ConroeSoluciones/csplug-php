<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use LogicException;
use Override;

/**
 * Builder instance for {@see CertificadoCsd}
 */
final class CertificadoCsdBuilder extends Builder
{
    protected ?string $cer = null;
    protected ?string $key = null;
    protected ?string $password = null;

    /** @var string[] */
    protected array $requiredFields = ['cer', 'key', 'password'];

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

    #[Override]
    public function validate(): void
    {
        parent::validate();
    }

    #[Override]
    public function build(): CertificadoCsd
    {
        $this->validate();

        return new CertificadoCsd($this);
    }

    public function getCer(): string
    {
        if ($this->cer === null) {
            throw new LogicException('El atributo no ha sido inicializado');
        }

        return $this->cer;
    }

    public function getKey(): string
    {
        if ($this->key === null) {
            throw new LogicException('El atributo no ha sido inicializado');
        }

        return $this->key;
    }

    public function getPassword(): string
    {
        if ($this->password === null) {
            throw new LogicException('El atributo no ha sido inicializado');
        }

        return $this->password;
    }
}
