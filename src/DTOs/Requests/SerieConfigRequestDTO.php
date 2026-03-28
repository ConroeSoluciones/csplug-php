<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use InvalidArgumentException;
use JsonSerializable;
use Override;

use function in_array;
use function preg_match;

/**
 * DTO for configuring a Serie.
 */
final class SerieConfigRequestDTO implements JsonSerializable
{
    public const ORIENTATION_PORTRAIT = 'portrait';
    public const ORIENTATION_LANDSCAPE = 'landscape';

    private ?string $template = null;
    private ?string $logo = null;
    private ?string $logoBinary = null;
    private ?int $decimalQuantity = null;
    private ?string $orientation = null;
    private ?string $accentColor = null;
    private ?string $fontColor = null;
    private ?bool $nombreComercialEnabled = null;
    private ?string $nombreComercial = null;
    private ?string $sucursal = null;

    /**
     * Template name (required when creating config).
     */
    public function withTemplate(string $template): self
    {
        if ($template === '') {
            throw new InvalidArgumentException('Template name cannot be empty');
        }

        $this->template = $template;

        return $this;
    }

    /**
     * Logo in base64 format: data:image/png;base64,...
     */
    public function withLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Binary logo data.
     */
    public function withLogoBinary(string $logoBinary): self
    {
        $this->logoBinary = $logoBinary;

        return $this;
    }

    /**
     * Number of decimal places.
     */
    public function withDecimalQuantity(int $decimalQuantity): self
    {
        if ($decimalQuantity < 0) {
            throw new InvalidArgumentException('Decimal quantity must be non-negative');
        }

        $this->decimalQuantity = $decimalQuantity;

        return $this;
    }

    /**
     * Page orientation: portrait or landscape.
     */
    public function withOrientation(string $orientation): self
    {
        $validOrientations = [self::ORIENTATION_PORTRAIT, self::ORIENTATION_LANDSCAPE];
        if (!in_array($orientation, $validOrientations, true)) {
            throw new InvalidArgumentException('Orientation must be portrait or landscape');
        }

        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Accent color in hexadecimal format (e.g., #FF5733).
     */
    public function withAccentColor(string $accentColor): self
    {
        if (preg_match('/^#[a-fA-F0-9]{6}$/', $accentColor) !== 1) {
            throw new InvalidArgumentException(
                'Accent color must be in hexadecimal format (e.g., #FF5733)',
            );
        }

        $this->accentColor = $accentColor;

        return $this;
    }

    /**
     * Font color in hexadecimal format (e.g., #333333).
     */
    public function withFontColor(string $fontColor): self
    {
        if (preg_match('/^#[a-fA-F0-9]{6}$/', $fontColor) !== 1) {
            throw new InvalidArgumentException(
                'Font color must be in hexadecimal format (e.g., #333333)',
            );
        }

        $this->fontColor = $fontColor;

        return $this;
    }

    /**
     * Enable commercial name display.
     */
    public function withNombreComercialEnabled(bool $enabled): self
    {
        $this->nombreComercialEnabled = $enabled;

        return $this;
    }

    /**
     * Commercial name.
     */
    public function withNombreComercial(string $nombreComercial): self
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * Branch office name.
     */
    public function withSucursal(string $sucursal): self
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    /**
     * Build and validate the DTO.
     */
    public function build(): self
    {
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->template !== null) {
            $data['template'] = $this->template;
        }

        if ($this->logo !== null) {
            $data['logo'] = $this->logo;
        }

        if ($this->logoBinary !== null) {
            $data['logo_binary'] = $this->logoBinary;
        }

        if ($this->decimalQuantity !== null) {
            $data['decimal_quantity'] = $this->decimalQuantity;
        }

        if ($this->orientation !== null) {
            $data['orientation'] = $this->orientation;
        }

        if ($this->accentColor !== null) {
            $data['accent_color'] = $this->accentColor;
        }

        if ($this->fontColor !== null) {
            $data['font_color'] = $this->fontColor;
        }

        if ($this->nombreComercialEnabled !== null) {
            $data['nombre_comercial_enabled'] = $this->nombreComercialEnabled;
        }

        if ($this->nombreComercial !== null) {
            $data['nombre_comercial'] = $this->nombreComercial;
        }

        if ($this->sucursal !== null) {
            $data['sucursal'] = $this->sucursal;
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function getLogoBinary(): ?string
    {
        return $this->logoBinary;
    }

    public function getDecimalQuantity(): ?int
    {
        return $this->decimalQuantity;
    }

    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    public function getAccentColor(): ?string
    {
        return $this->accentColor;
    }

    public function getFontColor(): ?string
    {
        return $this->fontColor;
    }

    public function isNombreComercialEnabled(): ?bool
    {
        return $this->nombreComercialEnabled;
    }

    public function getNombreComercial(): ?string
    {
        return $this->nombreComercial;
    }

    public function getSucursal(): ?string
    {
        return $this->sucursal;
    }
}
