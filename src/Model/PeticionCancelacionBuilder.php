<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use InvalidArgumentException;
use LogicException;
use Override;

use function preg_match;

final class PeticionCancelacionBuilder extends Builder
{
    protected ?string $uuid = null;
    protected ?string $motivo = null;
    protected ?string $rfcEmisor = null;
    protected ?string $rfcReceptor = null;
    protected ?string $emailEmisor = null;
    protected ?string $emailReceptor = null;
    protected ?string $folioSustitucion = null;
    protected ?string $contractId = null;

    /** @var string[] */
    protected array $requiredFields = [
        'uuid', 'motivo', 'rfcEmisor', 'rfcReceptor',
    ];

    public function withUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function withMotivo(string $motivo): self
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function withRfcEmisor(Rfc $rfcEmisor): self
    {
        $this->rfcEmisor = $rfcEmisor->getValue();

        return $this;
    }

    public function withRfcReceptor(Rfc $rfcReceptor): self
    {
        $this->rfcReceptor = $rfcReceptor->getValue();

        return $this;
    }

    public function withEmailEmisor(string $emailEmisor): self
    {
        $this->emailEmisor = $emailEmisor;

        return $this;
    }

    public function withEmailReceptor(string $emailReceptor): self
    {
        $this->emailReceptor = $emailReceptor;

        return $this;
    }

    public function withFolioSustitucion(string $folioSustitucion): self
    {
        $this->folioSustitucion = $folioSustitucion;

        return $this;
    }

    public function withContractId(string $contractId): self
    {
        $this->contractId = $contractId;

        return $this;
    }

    public function getUuid(): string
    {
        if ($this->uuid === null) {
            throw new LogicException('El campo uuid no ha sido inicializado.');
        }

        return $this->uuid;
    }

    public function getMotivo(): string
    {
        if ($this->motivo === null) {
            throw new LogicException('El campo motivo no ha sido inicializado.');
        }

        return $this->motivo;
    }

    public function getRfcEmisor(): string
    {
        if ($this->rfcEmisor === null) {
            throw new LogicException('El campo rfcEmisor no ha sido inicializado.');
        }

        return $this->rfcEmisor;
    }

    public function getRfcReceptor(): string
    {
        if ($this->rfcReceptor === null) {
            throw new LogicException('El campo rfcReceptor no ha sido inicializado.');
        }

        return $this->rfcReceptor;
    }

    public function getEmailEmisor(): ?string
    {
        return $this->emailEmisor;
    }

    public function getEmailReceptor(): ?string
    {
        return $this->emailReceptor;
    }

    public function getFolioSustitucion(): ?string
    {
        return $this->folioSustitucion;
    }

    public function getContractId(): ?string
    {
        return $this->contractId;
    }

    #[Override]
    public function validate(): void
    {
        parent::validate();
        $uuid = $this->getUuid();

        if (
            !preg_match(
                '/[a-f0-9A-F]{8}-[a-f0-9A-F]{4}-[a-f0-9A-F]{4}-[a-f0-9A-F]{4}-[a-f0-9A-F]{12}$/',
                $uuid,
            )
        ) {
            throw new InvalidArgumentException('Valor de UUID invalido: ' . $uuid);
        }
    }

    #[Override]
    public function build(): PeticionCancelacion
    {
        if ($this->motivo === '01' && !isset($this->folioSustitucion)) {
            throw new LogicException("El campo folioSustitucion es obligatorio cuando el motivo es '01'.");
        }

        return new PeticionCancelacion($this);
    }
}
