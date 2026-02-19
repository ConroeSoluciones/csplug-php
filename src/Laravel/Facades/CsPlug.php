<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Laravel\Facades;

use Csfacturacion\CsPlug\CsPlugClient;
use Csfacturacion\CsPlug\Resources\CertificadosEmisorHijoResource;
use Csfacturacion\CsPlug\Resources\CertificadosResource;
use Csfacturacion\CsPlug\Resources\EmisoresHijosResource;
use Csfacturacion\CsPlug\Resources\PlantillasResource;
use Csfacturacion\CsPlug\Resources\SeriesEmisorHijoResource;
use Csfacturacion\CsPlug\Resources\SeriesResource;
use Illuminate\Support\Facades\Facade;

/**
 * @method static EmisoresHijosResource emisoresHijos()
 * @method static CertificadosResource certificados()
 * @method static CertificadosEmisorHijoResource certificadosEmisorHijo()
 * @method static PlantillasResource plantillas()
 * @method static SeriesEmisorHijoResource seriesEmisorHijo()
 * @method static SeriesResource series()
 * 
 * @see \Csfacturacion\CsPlug\CsPlugClient
 */
final class CsPlug extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CsPlugClient::class;
    }
}
