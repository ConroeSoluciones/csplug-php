<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use InvalidArgumentException;
use JsonSerializable;
use Override;

use function preg_match;

/**
 * DTO for creating/updating an EmisorHijo.
 */
final class EmisorHijoRequestDTO implements JsonSerializable
{
    private ?string $rfc = null;
    private ?string $razonSocial = null;
    private ?string $domicilioFiscal = null;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $configuracion = null;

    /**
     * RFC is required for creation.
     */
    public function withRfc(string $rfc): self
    {
        $this->validateRfc($rfc);
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Business name is required.
     */
    public function withRazonSocial(string $razonSocial): self
    {
        if ($razonSocial === '') {
            throw new InvalidArgumentException('Razon social cannot be empty');
        }
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Fiscal address is required.
     */
    public function withDomicilioFiscal(string $domicilioFiscal): self
    {
        if ($domicilioFiscal === '') {
            throw new InvalidArgumentException('Domicilio fiscal cannot be empty');
        }
        $this->domicilioFiscal = $domicilioFiscal;

        return $this;
    }

    /**
     * Optional configuration.
     *
     * @param array<string, mixed> $configuracion
     */
    public function withConfiguracion(array $configuracion): self
    {
        $this->configuracion = $configuracion;

        return $this;
    }

    /**
     * Build and validate the DTO.
     */
    public function build(): self
    {
        if ($this->rfc === null || $this->razonSocial === null || $this->domicilioFiscal === null) {
            throw new InvalidArgumentException(
                'RFC, Razon Social, and Domicilio Fiscal are required',
            );
        }

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $this->build();

        $data = [
            'rfc' => $this->rfc,
            'razon_social' => $this->razonSocial,
            'domicilio_fiscal' => $this->domicilioFiscal,
        ];

        if ($this->configuracion !== null) {
            $data['configuracion'] = $this->configuracion;
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

    public function getRfc(): ?string
    {
        return $this->rfc;
    }

    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    public function getDomicilioFiscal(): ?string
    {
        return $this->domicilioFiscal;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getConfiguracion(): ?array
    {
        return $this->configuracion;
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
