<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use InvalidArgumentException;
use JsonSerializable;
use Override;

use function in_array;
use function preg_match;

/**
 * DTO for cancelar (cancel) a CFDI.
 */
final class CfdiCancelarRequestDTO implements JsonSerializable
{
    public const string CON_RELACION = '01';
    public const string SIN_RELACION = '02';
    public const string NO_OPERACION = '03';
    public const string RELACION_GLOBAL = '04';
    private ?string $uuid = null;
    private ?string $rfcEmisor = null;
    private ?string $rfcReceptor = null;
    private ?string $emailEmisor = null;
    private ?string $emailReceptor = null;
    private ?string $uuidRelacionado = null;
    private ?string $motivoCancelacion = null;
    private ?string $contractId = null;
    private ?string $webhookUrl = null;

    public function withRfcEmisor(string $rfcEmisor): self
    {
        $this->validateRfc($rfcEmisor);
        $this->rfcEmisor = $rfcEmisor;

        return $this;
    }

    public function withRfcReceptor(string $rfcReceptor): self
    {
        $this->validateRfc($rfcReceptor);
        $this->rfcReceptor = $rfcReceptor;

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

    public function withUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function withUuidRelacionado(string $uuidRelacionado): self
    {
        $this->uuidRelacionado = $uuidRelacionado;

        return $this;
    }

    public function withContractId(string $contractId): self
    {
        $this->contractId = $contractId;

        return $this;
    }

    public function withMotivoCancelacion(string $motivoCancelacion): self
    {
        if (
            !in_array(
                $motivoCancelacion,
                [self::SIN_RELACION, self::CON_RELACION, self::NO_OPERACION, self::RELACION_GLOBAL],
                true,
            )
        ) {
            throw new InvalidArgumentException('MotivoCancelacion must be 
            01 (Comprobantes emitidos con errores con relación), 
            02 (Comprobantes emitidos con errores sin relación), 
            03 (No se llevó a cabo la operación) or 
            04 (Operación nominativa relacionada en una factura global)');
        }

        $this->motivoCancelacion = $motivoCancelacion;

        return $this;
    }

    public function withWebhookUrl(string $webhookUrl): self {
        $this->webhookUrl = $webhookUrl;

        return $this;
    }

    public function build(): self
    {
        if ($this->uuid === '') {
            throw new InvalidArgumentException('UUID cannot be empty');
        }

        if ($this->rfcReceptor === null || $this->rfcReceptor === '') {
            throw new InvalidArgumentException('RFC Receptor cannot be empty');
        }

        if ($this->rfcEmisor === null || $this->rfcEmisor === '') {
            throw new InvalidArgumentException('RFC Emisor cannot be empty');
        }

        if ($this->motivoCancelacion === self::CON_RELACION && $this->uuidRelacionado === null) {
            throw new InvalidArgumentException('UUID Relacionada cannot be empty if motivoCancelacion is CON_RELACION');
        }

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $data = [
            'uuid' => $this->uuid,
            'rfcEmisor' => $this->rfcEmisor,
            'rfcReceptor' => $this->rfcReceptor,
            'motivo' => $this->motivoCancelacion,
        ];

        if ($this->emailEmisor !== null) {
            $data['emailEmisor'] = $this->emailEmisor;
        }

        if ($this->emailReceptor !== null) {
            $data['emailReceptor'] = $this->emailReceptor;
        }

        if ($this->motivoCancelacion === self::CON_RELACION) {
            $data['uuidRelacionado'] = $this->uuidRelacionado;
        }

        if ($this->contractId !== null) {
            $data['rfcCliente'] = $this->contractId;
        }

        if ($this->webhookUrl !== null) {
            $data['webhookUrl'] = $this->webhookUrl;
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    private function validateRfc(string $rfc): void
    {
        if ($rfc === '') {
            throw new InvalidArgumentException('RFC cannot be empty');
        }

        // Basic RFC validation (13 or 12 characters for moral/persona fisica)
        if (!preg_match('/^[A-Z&Ñ]{3,4}\d{6}[A-Z\d]{3}$/i', $rfc)) {
            throw new InvalidArgumentException('Invalid RFC format');
        }
    }
}
