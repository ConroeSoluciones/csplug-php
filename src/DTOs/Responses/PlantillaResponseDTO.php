<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use function is_int;
use function is_string;

/**
 * Response DTO for a Plantilla (Template).
 */
final readonly class PlantillaResponseDTO
{
    public function __construct(
        public int $idPlantilla,
        public string $clavePlantilla,
        public string $nombrePlantilla,
        public string $descripcion,
        public ?string $rutaPlantilla,
        public ?string $vistaPrevia,
        public string $fecha,
        public int $tipo,
        public int $version,
        public int $versionLibreria,
        public ?string $status,
        public ?string $nombreService,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        // Support both API response formats (snake_case and UPPERCASE)
        $idPlantilla = $data['id_plantilla'] ?? $data['IDPLANTILLA'] ?? null;
        $clavePlantilla = $data['clave_plantilla'] ?? $data['CLAVEPLANTILLA'] ?? null;
        $nombrePlantilla = $data['nombre_plantilla'] ?? $data['NOMBRE_PLANTILLA'] ?? null;
        $descripcion = $data['descripcion'] ?? $data['DESCRIPCION'] ?? '';
        $rutaPlantilla = $data['ruta_plantilla'] ?? $data['RUTA_PLANTILLA'] ?? null;
        $vistaPrevia = $data['vista_previa'] ?? $data['VISTA_PREVIA'] ?? null;
        $fecha = $data['fecha'] ?? $data['FECHA'] ?? '';
        $tipo = $data['tipo'] ?? $data['TIPO'] ?? 0;
        $version = $data['version'] ?? $data['VERSION'] ?? 0;
        $versionLibreria = $data['version_libreria'] ?? $data['VERSION_LIBRERIA'] ?? 0;
        $status = $data['status'] ?? $data['STATUS'] ?? null;
        $nombreService = $data['nombre_service'] ?? $data['NOMBRE_SERVICE'] ?? null;

        return new self(
            idPlantilla: is_int($idPlantilla) ? $idPlantilla : 0,
            clavePlantilla: is_string($clavePlantilla) ? $clavePlantilla : '',
            nombrePlantilla: is_string($nombrePlantilla) ? $nombrePlantilla : '',
            descripcion: is_string($descripcion) ? $descripcion : '',
            rutaPlantilla: is_string($rutaPlantilla) ? $rutaPlantilla : null,
            vistaPrevia: is_string($vistaPrevia) ? $vistaPrevia : null,
            fecha: is_string($fecha) ? $fecha : '',
            tipo: is_int($tipo) ? $tipo : 0,
            version: is_int($version) ? $version : 0,
            versionLibreria: is_int($versionLibreria) ? $versionLibreria : 0,
            status: is_string($status) ? $status : null,
            nombreService: is_string($nombreService) ? $nombreService : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id_plantilla' => $this->idPlantilla,
            'clave_plantilla' => $this->clavePlantilla,
            'nombre_plantilla' => $this->nombrePlantilla,
            'descripcion' => $this->descripcion,
            'ruta_plantilla' => $this->rutaPlantilla,
            'vista_previa' => $this->vistaPrevia,
            'fecha' => $this->fecha,
            'tipo' => $this->tipo,
            'version' => $this->version,
            'version_libreria' => $this->versionLibreria,
            'status' => $this->status,
            'nombre_service' => $this->nombreService,
        ];
    }
}
