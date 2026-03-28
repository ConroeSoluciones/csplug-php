<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\DTOs\Requests;

use InvalidArgumentException;
use JsonSerializable;
use Override;

/**
 * DTO for cancelar (cancel) a CFDI.
 */
final class CfdiCancelarRequestDTO implements JsonSerializable
{
    private string $uuid;
    private string $rfcEmisor;
    /** @var list<string> */
    private array $folios;

    /**
     * @param list<string> $folios
     */
    public function __construct(
        string $uuid,
        string $rfcEmisor,
        array $folios = [],
    ) {
        if ($uuid === '') {
            throw new InvalidArgumentException('UUID cannot be empty');
        }

        if ($rfcEmisor === '') {
            throw new InvalidArgumentException('RFC Emisor cannot be empty');
        }

        $this->uuid = $uuid;
        $this->rfcEmisor = $rfcEmisor;
        $this->folios = $folios;
    }

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $data = [
            'uuid' => $this->uuid,
            'rfcEmisor' => $this->rfcEmisor,
        ];

        if ($this->folios !== []) {
            $data['folios'] = $this->folios;
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

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getRfcEmisor(): string
    {
        return $this->rfcEmisor;
    }

    /**
     * @return list<string>
     */
    public function getFolios(): array
    {
        return $this->folios;
    }
}
