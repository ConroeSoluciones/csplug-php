<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\Parameters;
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
     * @param string $uri
     * @param Parameters $params
     * @param HttpMethod $method
     * @param RequestOptions|null $options
     * @return HttpRequest
     */
    public function createRequest(
        string $uri,
        Parameters $params,
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
        $xRfc = $options?->getXRfc() ?? $this->config->xRfc;

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
        if ($params->getQueryParams()) {
            $url .= '?' . http_build_query($params->getQueryParams());
        }

        $req = new HttpRequest(
            url: $url,
            params: $params,
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
