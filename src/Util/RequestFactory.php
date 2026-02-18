<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\CsPlug\Model\AuthMode;
use RuntimeException;

class RequestFactory
{
    public function __construct(
        private readonly CsPlugConfig $config
    ) {
    }

    /**
     * @param array<string, mixed>|null $body
     */
    public function createRequest(
        string $method,
        string $path,
        ?RequestOptions $options = null,
        ?array $body = null
    ): HttpRequest {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        // 1. Authentication
        if ($this->config->authMode === AuthMode::BASIC) {
            $token = $this->resolveBasicToken();
            $headers['Authorization'] = 'Basic ' . $token;
        } else {
             if ($this->config->bearerToken === null) {
                 throw new RuntimeException('Bearer token is required for BEARER auth mode');
             }
             $headers['Authorization'] = 'Bearer ' . $this->config->bearerToken;
        }

        // 2. X-Servicio
        $xServicio = $options?->xServicio ?? $this->config->xServicio;
        if ($xServicio !== null) {
            $headers['X-Servicio'] = $xServicio -> value;
        }

        // 3. X-Rfc (Only mandatory for Bearer usually, but logic allows both if configured)
        // Logic: specific override > config global
        $xRfc = $options?->xRfc ?? $this->config->xRfc;
        if ($xRfc !== null) {
            $headers['X-Rfc'] = $xRfc;
        } elseif ($this->config->authMode === AuthMode::BEARER) {
             // If Bearer mode and no X-Rfc, might be an issue depending on strictness.
             // For now we allow it to be missing if not passed, but API might 400.
        }

        // 4. Custom Headers
        if ($options !== null) {
            foreach ($options->headers as $key => $value) {
                $headers[$key] = $value;
            }
        }
        
        // 5. Query Params
        $url = rtrim($this->config->baseUri, '/') . '/' . ltrim($path, '/');
        if ($options !== null && count($options->query) > 0) {
            $url .= '?' . http_build_query($options->query);
        }

        $requestOptions = [
            'headers' => $headers,
        ];
        
        if ($body !== null) {
             $requestOptions['json'] = $body;
        }
        
        // Timeouts
        $requestOptions['timeout'] = $this->config->timeout; // This might need to be set on Client instantiation actually in Symfony HttpClient

        return new HttpRequest(
            method: $method,
            url: $url,
            options: $requestOptions
        );
    }

    private function resolveBasicToken(): string
    {
        if ($this->config->basicTokenBase64 !== null) {
            return $this->config->basicTokenBase64;
        }
        if ($this->config->username !== null && $this->config->password !== null) {
            return base64_encode($this->config->username . ':' . $this->config->password);
        }
        throw new RuntimeException('Username/Password or Base64 Token required for BASIC auth');
    }
}
