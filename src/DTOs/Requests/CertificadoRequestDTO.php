<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use InvalidArgumentException;
use JsonSerializable;
use Override;

/**
 * DTO for uploading a certificate (CSD).
 */
final class CertificadoRequestDTO implements JsonSerializable
{
    private ?string $cer = null;
    private ?string $key = null;
    private ?string $password = null;

    /**
     * Certificate in base64 format.
     */
    public function withCer(string $cer): self
    {
        if ($cer === '') {
            throw new InvalidArgumentException('Certificate (cer) cannot be empty');
        }
        $this->cer = $cer;

        return $this;
    }

    /**
     * Private key in base64 format.
     */
    public function withKey(string $key): self
    {
        if ($key === '') {
            throw new InvalidArgumentException('Private key cannot be empty');
        }
        $this->key = $key;

        return $this;
    }

    /**
     * Password for the private key.
     */
    public function withPassword(string $password): self
    {
        if ($password === '') {
            throw new InvalidArgumentException('Password cannot be empty');
        }
        $this->password = $password;

        return $this;
    }

    /**
     * Build and validate the DTO.
     */
    public function build(): self
    {
        if ($this->cer === null || $this->key === null || $this->password === null) {
            throw new InvalidArgumentException(
                'Certificate (cer), private key (key), and password are required',
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

        return [
            'cer' => $this->cer,
            'key' => $this->key,
            'password' => $this->password,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    public function getCer(): ?string
    {
        return $this->cer;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
