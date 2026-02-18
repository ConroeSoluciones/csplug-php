<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

final class EmisorHijoParams
{
    private array $configuracion = [];
    private EmisorHijoConfiguracion $configuracionEmisor;
    
    // Constructor privado para forzar el uso de métodos estáticos o fluent si se prefiere,
    // o público si queremos instanciación directa. 
    // Dado el patrón "BuilderParams", usaremos un constructor claro con los obligatorios.
    public function __construct(
        private string $rfc,
        private string $razonSocial,
        private string $domicilioFiscal
    ) {
    }

    public static function create(string $rfc, string $razonSocial, string $domicilioFiscal): self
    {
        return new self($rfc, $razonSocial, $domicilioFiscal);
    }

    /**
     * @param array<string, mixed> $config
     */
    public function withConfiguracion(array $config): self
    {
        $this->configuracion = $config;
        return $this;
    }

    public function getRfc(): string
    {
        return $this->rfc;
    }

    public function getRazonSocial(): string
    {
        return $this->razonSocial;
    }

    public function getDomicilioFiscal(): string
    {
        return $this->domicilioFiscal;
    }

    public function getConfiguracion(): array
    {
        return $this->configuracion;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'RFC' => $this->rfc,
            'RAZONSOCIAL' => $this->razonSocial,
            'DOMICILIOFISCAL' => $this->domicilioFiscal,
            'CONFIGURACION' => $this->configuracion,
        ];
    }
}
