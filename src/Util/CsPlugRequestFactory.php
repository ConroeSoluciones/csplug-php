<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Util;

use Csfacturacion\CsPlug\Auth\AuthStrategyFactory;
use Csfacturacion\CsPlug\Contracts\AuthStrategy;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\RequestOptions;
use JsonSerializable;
use Override;

use function http_build_query;

final readonly class CsPlugRequestFactory implements RequestFactory
{
    private AuthStrategy $authStrategy;

    public function __construct(
        private CsPlugConfig $config,
    ) {
        $this->authStrategy = AuthStrategyFactory::create($config);
    }

    /**
     * @param array<mixed> $queryParams
     * @param JsonSerializable|array<string, mixed>|null $body
     */
    #[Override]
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
            'Servicio' => $xServicio->value,
            'Authorization' => $this->authStrategy->getAuthorizationHeader(),
        ];

        $authHeaders = $this->authStrategy->getAdditionalHeaders($options);
        foreach ($authHeaders as $key => $value) {
            $headers[$key] = $value;
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
}
