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
use Override;

/**
 * @see \Csfacturacion\CsPlug\CsPlugClient
 *
 * @method static EmisoresHijosResource emisoresHijos()
 * @method static CertificadosResource certificados()
 * @method static CertificadosEmisorHijoResource certificadosEmisorHijo()
 * @method static PlantillasResource plantillas()
 * @method static SeriesEmisorHijoResource seriesEmisorHijo()
 * @method static SeriesResource series()
 */
final class CsPlug extends Facade
{
    /**
     * @return string
     */
    #[Override]
    protected static function getFacadeAccessor()
    {
        return CsPlugClient::class;
    }
}
