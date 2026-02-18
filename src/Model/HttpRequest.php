<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

class HttpRequest
{
    private HttpMethod $httpMethod;
    private string $url;
    private ?Parameters $params;
    private array $headers;

    public function __construct(
        string $url,
        ?Parameters $params,
        HttpMethod $method = HttpMethod::GET,
    ) {
        $this->httpMethod = $method;
        $this->url = $url;
        $this->params = $params;
        $this->headers = [];
        if($params->getEntity()) {
            $this->headers['Content-Type'] = 'application/json';
        }
    }

    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getParams(): Parameters
    {
        return $this->params;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name, ?string $default = null): string|null|array{
        return $this->headers[$name] ?? $default;
    }

    public function setHeaders(array $headers): self{
        $this->headers = $headers;

        return $this;
    }

    public function addHeaders(array $headers) : self{
        foreach($headers as $header => $value){
            $this->headers[$header] = $value;
        }
        return $this;
    }

    public function addHeader(string $name, string $value): self{
        $this->headers[$name] = $value;
        return $this;
    }
}
