<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use JsonSerializable;
use Override;

final class PeticionCancelacion implements Buildable, JsonSerializable
{
    private readonly string $uuid;
    private readonly string $motivo;
    private readonly string $rfcEmisor;
    private readonly string $rfcReceptor;
    private readonly ?string $emailEmisor;
    private readonly ?string $emailReceptor;
    private readonly ?string $folioSustitucion;
    private readonly ?string $contractId;

    public function __construct(PeticionCancelacionBuilder $builder)
    {
        $builder->validate();
        $this->uuid = $builder->getUuid();
        $this->motivo = $builder->getMotivo();
        $this->rfcEmisor = $builder->getRfcEmisor();
        $this->rfcReceptor = $builder->getRfcReceptor();
        $this->emailEmisor = $builder->getEmailEmisor();
        $this->emailReceptor = $builder->getEmailReceptor();
        $this->folioSustitucion = $builder->getFolioSustitucion();
        $this->contractId = $builder->getContractId();
    }

    public static function builder(): PeticionCancelacionBuilder
    {
        return new PeticionCancelacionBuilder();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getMotivo(): string
    {
        return $this->motivo;
    }

    public function getRfcEmisor(): string
    {
        return $this->rfcEmisor;
    }

    public function getRfcReceptor(): string
    {
        return $this->rfcReceptor;
    }

    public function getEmailEmisor(): ?string
    {
        return $this->emailEmisor ?? null;
    }

    public function getEmailReceptor(): ?string
    {
        return $this->emailReceptor ?? null;
    }

    public function getFolioSustitucion(): ?string
    {
        return $this->folioSustitucion ?? null;
    }

    public function getContractId(): ?string
    {
        return $this->contractId ?? null;
    }

    /**
     * @return array|string[]
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $peticion = [
            'uuid' => $this->getUuid(),
            'motivo' => $this->getMotivo(),
            'rfcEmisor' => $this->getRfcEmisor(),
            'rfcReceptor' => $this->getRfcReceptor(),
        ];

        if ($this->getEmailEmisor() !== null) {
            $peticion['emailEmisor'] = $this->getEmailEmisor();
        }

        if ($this->getEmailReceptor() !== null) {
            $peticion['emailReceptor'] = $this->getEmailReceptor();
        }

        if ($this->getFolioSustitucion() !== null) {
            $peticion['uuidRelacionado'] = $this->getFolioSustitucion();
        }

        if ($this->getContractId() !== null) {
            $peticion['rfcCliente'] = $this->getContractId();
        }

        return $peticion;
    }
}
