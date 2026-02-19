<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\CsPlug\Model\AuthMode;
use JsonSerializable;
use RuntimeException;

class RequestFactory
{
    public function __construct(
        private readonly CsPlugConfig $config
    ) {
    }

    /**
     * @param string $uri
     * @param array $queryParams
     * @param JsonSerializable|array|null $body
     * @param HttpMethod $method
     * @param RequestOptions|null $options
     * @return HttpRequest
     */
    public function createRequest(
        string $uri,
        array $queryParams = [],
        JsonSerializable|array|null $body = null,
        HttpMethod $method = HttpMethod::GET,
        ?RequestOptions $options = null,
    ): HttpRequest {
        $xServicio = $options?->getXServicio() ?? $this->config->xServicio;
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Servicio' => $xServicio->value,
            'Authorization' => $this->resolveAuthorizationToken(),
        ];
        $xRfc = $options?->getContractId() ?? $this->config->contractId;

        if(empty($xRfc) && $this->config->authMode === AuthMode::BEARER) throw new RuntimeException('No tienes permiso para acceder a este recurso');

        if ($xRfc !== null) {
            $headers['X-Rfc'] = $xRfc;
        }

        if ($options) {
            foreach ($options->getHeaders() as $key => $value) {
                $headers[$key] = $value;
            }
        }

        $url = $this->config->baseUri . $uri;
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        $req = new HttpRequest(
            url: $url,
            body: $body,
            method: $method,
        );

        $req->setHeaders($headers);

        return $req;
    }

    private function resolveAuthorizationToken(): string
    {
        if ($this->config->authMode === AuthMode::BASIC) {
            return base64_encode($this->config->username . ':' . $this->config->password);
        } else {
            return 'Bearer ' . $this->config->bearerToken;
        }
    }
}
