<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Responses;

use function is_array;
use function is_bool;
use function is_numeric;
use function is_string;

/**
 * Response DTO for Serie Configuration.
 */
final readonly class SerieConfigResponseDTO
{
    /**
     * @param array<string, mixed>|null $config
     */
    public function __construct(
        public ?string $logo,
        public ?string $logoBinary,
        public ?int $decimalQuantity,
        public ?string $orientation,
        public ?string $accentColor,
        public ?string $fontColor,
        public ?bool $nombreComercialEnabled,
        public ?string $nombreComercial,
        public ?string $sucursal,
        public ?array $config = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $logo = $data['logo'] ?? $data['LOGO'] ?? null;
        $logoBinary = $data['logo_binary'] ?? $data['LOGO_BINARY'] ?? null;
        $decimalQuantity = $data['decimal_quantity'] ?? $data['DECIMAL_QUANTITY'] ?? null;
        $orientation = $data['orientation'] ?? $data['ORIENTATION'] ?? null;
        $accentColor = $data['accent_color'] ?? $data['ACCENT_COLOR'] ?? null;
        $fontColor = $data['font_color'] ?? $data['FONT_COLOR'] ?? null;
        $nombreComercialEnabled = $data['nombre_comercial_enabled']
            ?? $data['NOMBRE_COMERCIAL_ENABLED'] ?? null;
        $nombreComercial = $data['nombre_comercial'] ?? $data['NOMBRE_COMERCIAL'] ?? null;
        $sucursal = $data['sucursal'] ?? $data['SUCURSAL'] ?? null;
        $config = $data['config'] ?? $data['CONFIG'] ?? null;

        /** @var array<string, mixed>|null $configArray */
        $configArray = is_array($config) ? $config : null;

        return new self(
            logo: is_string($logo) ? $logo : null,
            logoBinary: is_string($logoBinary) ? $logoBinary : null,
            decimalQuantity: is_numeric($decimalQuantity) ? (int) $decimalQuantity : null,
            orientation: is_string($orientation) ? $orientation : null,
            accentColor: is_string($accentColor) ? $accentColor : null,
            fontColor: is_string($fontColor) ? $fontColor : null,
            nombreComercialEnabled: is_bool($nombreComercialEnabled) ? $nombreComercialEnabled : null,
            nombreComercial: is_string($nombreComercial) ? $nombreComercial : null,
            sucursal: is_string($sucursal) ? $sucursal : null,
            config: $configArray,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'logo' => $this->logo,
            'logo_binary' => $this->logoBinary,
            'decimal_quantity' => $this->decimalQuantity,
            'orientation' => $this->orientation,
            'accent_color' => $this->accentColor,
            'font_color' => $this->fontColor,
            'nombre_comercial_enabled' => $this->nombreComercialEnabled,
            'nombre_comercial' => $this->nombreComercial,
            'sucursal' => $this->sucursal,
        ];
    }
}
