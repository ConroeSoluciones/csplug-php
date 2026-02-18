<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use InvalidArgumentException;

final class CsPlugConfig
{
    private const DEFAULT_BASE_URI = 'https://csplug.csfacturacion.com';

    public function __construct(
        public string $baseUri = self::DEFAULT_BASE_URI,
        public AuthMode $authMode = AuthMode::BASIC,
        public ?string $username = null,
        public ?string $password = null,
        public ?string $basicTokenBase64 = null,
        public ?string $bearerToken = null,
        public ?string $xRfc = null,
        public Service $xServicio = Service::CSPLUG,
        public int $timeout = 30,
        public int $connectTimeout = 10,
        public bool $debug = false
    ) {
        $this->validate();
    }

    /**
     * @param array<string, mixed> $options
     */
    public static function fromArray(array $options): self
    {
        return new self(
            baseUri: $options['base_uri'] ?? self::DEFAULT_BASE_URI,
            authMode: isset($options['auth_mode']) && $options['auth_mode'] instanceof AuthMode
                ? $options['auth_mode']
                : AuthMode::BASIC,
            username: $options['username'] ?? null,
            password: $options['password'] ?? null,
            xRfc: $options['x_rfc'] ?? null,
            xServicio: isset($options['x_servicio']) && $options['x_servicio'] instanceof Service ? $options['x_servicio'] : Service::CSPLUG,
            timeout: (int) ($options['timeout'] ?? 30),
            connectTimeout: (int) ($options['connect_timeout'] ?? 10),
            debug: (bool) ($options['debug'] ?? false)
        );
    }

    function validate(): bool{
        if($this->authMode === AuthMode::BASIC){
            empty($this->username) ?? throw new InvalidArgumentException("El usuario no puede ser vacío");
            empty($this->password) ?? throw new InvalidArgumentException("El password no puede ser vacío");
        }

        if($this->authMode === AuthMode::BEARER && empty($this->bearerToken)){
            throw new InvalidArgumentException("El bearer token es requerido.");
        }

        return true;
    }
}
