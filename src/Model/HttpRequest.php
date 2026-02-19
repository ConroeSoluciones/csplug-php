<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

class HttpRequest
{
    private HttpMethod $httpMethod;
    private string $url;
    private \JsonSerializable|array|null $body;
    private array $headers;

    public function __construct(
        string $url,
        \JsonSerializable|array|null $body = null,
        HttpMethod $method = HttpMethod::GET,
    ) {
        $this->httpMethod = $method;
        $this->url = $url;
        $this->body = $body;
        $this->headers = [];
        if($body !== null) {
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

    public function getBody(): \JsonSerializable|array|null
    {
        return $this->body;
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
