<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use InvalidArgumentException;

use function is_int;
use function is_string;

readonly final class CsPlugConfig
{
    private const DEFAULT_BASE_URI = 'https://csplug.csfacturacion.com';

    public function __construct(
        private string $baseUri = self::DEFAULT_BASE_URI,
        private AuthMode $authMode = AuthMode::BASIC,
        private ?string $username = null,
        private ?string $password = null,
        private ?string $bearerToken = null,
        private ?string $contractId = null,
        private Service $xServicio = Service::CSPLUG,
        private int $timeout = 30,
        private int $connectTimeout = 10,
        private bool $debug = false,
    ) {
        $this->validate();
    }

    /**
     * @param array<string, mixed> $options
     */
    public static function fromArray(array $options): self
    {
        /** @var AuthMode|int|string|null $authModeRaw */
        $authModeRaw = $options['auth_mode'] ?? null;
        if ($authModeRaw instanceof AuthMode) {
            $authMode = $authModeRaw;
        } elseif (is_string($authModeRaw) || is_int($authModeRaw)) {
            $authMode = AuthMode::tryFrom($authModeRaw) ?? AuthMode::BASIC;
        } else {
            $authMode = AuthMode::BASIC;
        }

        /** @var Service|int|string|null $xServicioRaw */
        $xServicioRaw = $options['x_servicio'] ?? null;
        if ($xServicioRaw instanceof Service) {
            $xServicio = $xServicioRaw;
        } elseif (is_string($xServicioRaw) || is_int($xServicioRaw)) {
            $xServicio = Service::tryFrom($xServicioRaw) ?? Service::CSPLUG;
        } else {
            $xServicio = Service::CSPLUG;
        }

        /** @var int|null $timeoutRaw */
        $timeoutRaw = $options['timeout'] ?? null;
        $timeout = is_int($timeoutRaw) ? $timeoutRaw : 30;

        /** @var int|null $connectTimeoutRaw */
        $connectTimeoutRaw = $options['connect_timeout'] ?? null;
        $connectTimeout = is_int($connectTimeoutRaw) ? $connectTimeoutRaw : 10;

        return new self(
            baseUri: isset($options['base_uri']) && is_string($options['base_uri'])
                ? $options['base_uri']
                : self::DEFAULT_BASE_URI,
            authMode: $authMode,
            username: isset($options['username']) && is_string($options['username'])
                ? $options['username']
                : null,
            password: isset($options['password']) && is_string($options['password'])
                ? $options['password']
                : null,
            bearerToken: isset($options['bearer_token']) && is_string($options['bearer_token'])
                ? $options['bearer_token']
                : null,
            contractId: isset($options['contract_id']) && is_string($options['contract_id'])
                ? $options['contract_id']
                : (isset($options['x_rfc']) && is_string($options['x_rfc']) ? $options['x_rfc'] : null),
            xServicio: $xServicio,
            timeout: $timeout,
            connectTimeout: $connectTimeout,
            debug: isset($options['debug']) ? (bool) $options['debug'] : false,
        );
    }

    public function getBearerToken(): string
    {
        if ($this->bearerToken === null) {
            throw new InvalidArgumentException('Bearer token is not set.');
        }

        return $this->bearerToken;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getAuthMode(): AuthMode
    {
        return $this->authMode;
    }

    public function getUsername(): string
    {
        if ($this->username === null) {
            throw new InvalidArgumentException('Username is not set.');
        }

        return $this->username;
    }

    public function getPassword(): string
    {
        if ($this->password === null) {
            throw new InvalidArgumentException('Password is not set.');
        }

        return $this->password;
    }

    public function getContractId(): string
    {
        if ($this->contractId === null) {
            throw new InvalidArgumentException('ContractId is not set.');
        }

        return $this->contractId;
    }

    public function getXServicio(): Service
    {
        return $this->xServicio;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }

    public function validate(): bool
    {
        if ($this->authMode === AuthMode::BASIC) {
            if ($this->username === null || $this->username === '') {
                throw new InvalidArgumentException('El usuario no puede ser vacío');
            }

            if ($this->password === null || $this->password === '') {
                throw new InvalidArgumentException('La contraseña no puede ser vacía');
            }
        }

        if ($this->authMode === AuthMode::BEARER && ($this->bearerToken === null || $this->bearerToken === '')) {
            throw new InvalidArgumentException('El bearer token es requerido.');
        }

        return true;
    }
}
