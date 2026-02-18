<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

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
    }

    /**
     * @param array<string, mixed> $options
     */
    public static function fromArray(array $options): self
    {
        return new self(
            baseUri: $options['base_uri'] ?? self::DEFAULT_BASE_URI,
            authMode: isset($options['auth_mode']) 
                ? AuthMode::from($options['auth_mode']) 
                : AuthMode::BASIC,
            username: $options['username'] ?? null,
            password: $options['password'] ?? null,
            basicTokenBase64: $options['basic_token_base64'] ?? null,
            bearerToken: $options['bearer_token'] ?? null,
            xRfc: $options['x_rfc'] ?? null,
            xServicio: $options['x_servicio'] ?? null,
            timeout: (int) ($options['timeout'] ?? 30),
            connectTimeout: (int) ($options['connect_timeout'] ?? 10),
            debug: (bool) ($options['debug'] ?? false)
        );
    }
}
