<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use LogicException;
use Override;

/**
 * Builder instance for
 * {@see EmisorHijo}
 *
 * @psalm-suppress MissingConstructor
 */
final class EmisorHijoBuilder extends Builder
{
    protected Rfc $rfc;
    protected string $razonSocial;
    protected string $domicilioFiscal;
    protected ?EmisorHijoConfiguracion $configuracion = null;

    /** @var string[] */
    protected array $requiredFields = ['rfc', 'razonSocial', 'domicilioFiscal'];

    public function withRfc(Rfc $rfc): self
    {
        $this->rfc = $rfc;

        return $this;
    }

    public function withRazonSocial(string $razonSocial): self
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    public function withDomicilioFiscal(string $domicilioFiscal): self
    {
        $this->domicilioFiscal = $domicilioFiscal;

        return $this;
    }

    public function withConfiguracion(EmisorHijoConfiguracion $configuracion): self
    {
        $this->configuracion = $configuracion;

        return $this;
    }

    #[Override]
    public function build(): EmisorHijo
    {
        $this->validate();

        return new EmisorHijo($this);
    }

    public function getRfc(): Rfc
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (!isset($this->rfc)) {
            throw new LogicException('El campo rfc no ha sido inicializado.');
        }

        return $this->rfc;
    }

    public function getRazonSocial(): string
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (!isset($this->razonSocial)) {
            throw new LogicException('El campo razonSocial no ha sido inicializado.');
        }

        return $this->razonSocial;
    }

    public function getDomicilioFiscal(): string
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (!isset($this->domicilioFiscal)) {
            throw new LogicException('El campo domicilioFiscal no ha sido inicializado.');
        }

        return $this->domicilioFiscal;
    }

    public function getConfiguracion(): ?EmisorHijoConfiguracion
    {
        return $this->configuracion ?? null;
    }
}
