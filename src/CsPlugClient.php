<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug;

use Csfacturacion\CsPlug\Contracts\HttpClient;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Resources\CertificadosEmisorHijoResource;
use Csfacturacion\CsPlug\Resources\CertificadosResource;
use Csfacturacion\CsPlug\Resources\CfdiResource;
use Csfacturacion\CsPlug\Resources\EmisoresHijosResource;
use Csfacturacion\CsPlug\Resources\PlantillasResource;
use Csfacturacion\CsPlug\Resources\RetencionResource;
use Csfacturacion\CsPlug\Resources\SeriesEmisorHijoResource;
use Csfacturacion\CsPlug\Resources\SeriesResource;
use Csfacturacion\CsPlug\Util\CsPlugRequestFactory;
use Csfacturacion\CsPlug\Util\HttpClientAdapter;

final class CsPlugClient
{
    private HttpClient $client;
    private RequestFactory $requestFactory;

    public function __construct(
        private readonly CsPlugConfig $config,
        ?HttpClient $httpClient = null,
        ?RequestFactory $requestFactory = null,
    ) {
        $this->client = $httpClient ?? new HttpClientAdapter();
        $this->requestFactory = $requestFactory ?? new CsPlugRequestFactory($config);
    }

    /**
     * @param array<string, mixed> $configOptions
     */
    public static function create(array $configOptions): self
    {
        return new self(CsPlugConfig::fromArray($configOptions));
    }

    public function emisoresHijos(): EmisoresHijosResource
    {
        return new EmisoresHijosResource($this->client, $this->requestFactory, $this->config);
    }

    public function certificados(): CertificadosResource
    {
        return new CertificadosResource($this->client, $this->requestFactory, $this->config);
    }

    public function certificadosEmisorHijo(): CertificadosEmisorHijoResource
    {
        return new CertificadosEmisorHijoResource($this->client, $this->requestFactory, $this->config);
    }

    public function plantillas(): PlantillasResource
    {
        return new PlantillasResource($this->client, $this->requestFactory, $this->config);
    }

    public function seriesEmisorHijo(): SeriesEmisorHijoResource
    {
        return new SeriesEmisorHijoResource($this->client, $this->requestFactory, $this->config);
    }

    public function series(): SeriesResource
    {
        return new SeriesResource($this->client, $this->requestFactory, $this->config);
    }

    public function cfdi(): CfdiResource
    {
        return new CfdiResource($this->client, $this->requestFactory, $this->config);
    }

    public function retencion() : RetencionResource
    {

        return new RetencionResource($this->client, $this->requestFactory, $this->config);
    }
}
