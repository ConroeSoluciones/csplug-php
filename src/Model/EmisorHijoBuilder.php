<?php
declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;
use LogicException;

/**
 * Builder instance for {@see EmisorHijo}
 *
 */
class EmisorHijoBuilder implements Builder
{
    private ?Rfc $rfc;
    private ?string $razonSocial;
    private ?string $domicilioFiscal;
    private ?EmisorHijoConfiguracion $configuracion;

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

    public function validate(): void
    {
        $requiredFields = [
            'rfc', 'razonSocial', 'domicilioFiscal'
        ];

        foreach ($requiredFields as $field) {
            if ($this->$field === null || $this->$field === '') {
                throw new LogicException("$field no puede ser null o vacio!");
            }
        }
    }

    public function build(): EmisorHijo{
        $this->validate();
        return new EmisorHijo($this);
    }

    public function getRfc(): Rfc
    {
        return $this->rfc;
    }

    public function getRazonSocial(): string
    {
        return $this->razonSocial;
    }

    public function getDomicilioFiscal(): string
    {
        return $this->domicilioFiscal;
    }

    public function getConfiguracion(): ?EmisorHijoConfiguracion
    {
        return $this->configuracion ?? null;
    }
}