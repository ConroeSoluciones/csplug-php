<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug;

use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Util\HttpClient;
use Csfacturacion\CsPlug\Util\RequestFactory;
use Csfacturacion\CsPlug\Resources\EmisoresHijosResource;
use Csfacturacion\CsPlug\Resources\CertificadosResource;
use Csfacturacion\CsPlug\Resources\SeriesResource;
use Csfacturacion\CsPlug\Resources\SeriesEmisorHijoResource;
use Csfacturacion\CsPlug\Resources\PlantillasResource;

final class CsPlugClient
{
    private HttpClient $client;
    private RequestFactory $requestFactory;

    public function __construct(
        private readonly CsPlugConfig $config
    ) {
        $this->client = new HttpClient();
        $this->requestFactory = new RequestFactory($config);
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

    public function plantillas(): PlantillasResource
    {
        return new PlantillasResource($this->client, $this->requestFactory, $this->config);
    }

    public function seriesEmisorHijo(): SeriesEmisorHijoResource
    {
        return new SeriesEmisorHijoResource($this->client, $this->requestFactory, $this->config);
    }
}
