<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use Csfacturacion\CsPlug\Model\AuthMode;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\RequestOptions;
use JsonSerializable;

use function base64_encode;
use function http_build_query;

final readonly class RequestFactory
{
    public function __construct(
        private CsPlugConfig $config,
    ) {
    }

    /**
     * @param array<mixed> $queryParams
     * @param JsonSerializable|array<string, mixed>|null $body
     */
    public function createRequest(
        string $uri,
        array $queryParams = [],
        JsonSerializable | array | null $body = null,
        HttpMethod $method = HttpMethod::GET,
        ?RequestOptions $options = null,
    ): HttpRequest {
        $xServicio = $options?->getXServicio() ?? $this->config->getXServicio();
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Servicio' => $xServicio->value,
            'Authorization' => $this->resolveAuthorizationToken(),
        ];

        if ($this->config->getAuthMode() === AuthMode::BEARER) {
            $xRfc = $options?->getContractId() ?? $this->config->getContractId();
            $headers['X-Rfc'] = $xRfc;
        }

        if ($options) {
            /**
             * @var string|string[] $value
             */
            foreach ($options->getHeaders() as $key => $value) {
                $headers[$key] = $value;
            }
        }

        $url = $this->config->getBaseUri() . $uri;
        if ($queryParams !== []) {
            $url .= '?' . http_build_query($queryParams);
        }

        $req = new HttpRequest(
            url: $url,
            body: $body,
            method: $method,
        );

        /** @var array<string, string|string[]> $typedHeaders */
        $typedHeaders = $headers;
        $req->setHeaders($typedHeaders);

        return $req;
    }

    private function resolveAuthorizationToken(): string
    {
        if ($this->config->getAuthMode() === AuthMode::BASIC) {
            return base64_encode($this->config->getUsername() . ':' . $this->config->getPassword());
        } else {
            return 'Bearer ' . $this->config->getBearerToken();
        }
    }
}
