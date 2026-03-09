<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use JsonSerializable;

final class HttpRequest
{
    private HttpMethod $httpMethod;
    private string $url;
    /**
     * @var JsonSerializable|array<mixed>|null
     */
    private JsonSerializable | array | null $body;
    /**
     * @var array<string, string|string[]>
     */
    private array $headers;

    /**
     * @param JsonSerializable|array<mixed>|null $body
     */
    public function __construct(
        string $url,
        JsonSerializable | array | null $body = null,
        HttpMethod $method = HttpMethod::GET,
    ) {
        $this->httpMethod = $method;
        $this->url = $url;
        $this->body = $body;
        $this->headers = [];
        if ($body !== null) {
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

    /**
     * @return JsonSerializable|array<mixed>|null
     */
    public function getBody(): JsonSerializable | array | null
    {
        return $this->body;
    }

    /**
     * @return array<string, string|string[]>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string|string[]|null
     */
    public function getHeader(string $name, ?string $default = null): string | array | null
    {
        return $this->headers[$name] ?? $default;
    }

    /**
     * @param array<string, string|string[]> $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array<string, string|string[]> $headers
     *
     * @return $this
     */
    public function addHeaders(array $headers): self
    {
        foreach ($headers as $header => $value) {
            $this->headers[$header] = $value;
        }

        return $this;
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }
}
