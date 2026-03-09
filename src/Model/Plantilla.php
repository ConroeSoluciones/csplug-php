<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use InvalidArgumentException;
use Override;

use function is_array;
use function json_decode;

use const JSON_THROW_ON_ERROR;

final class Plantilla implements Deserializable
{
    public function __construct(
        public int $id,
        public string $nombreService,
        public string $clavePlantilla,
    ) {
    }

    /**
     * @param array{
     *     IDPLANTILLA: int,
     *     NOMBRE_SERVICE: string,
     *     CLAVEPLANTILLA: string,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['IDPLANTILLA'],
            $data['NOMBRE_SERVICE'],
            $data['CLAVEPLANTILLA'],
        );
    }

    #[Override]
    public static function fromJson(string $raw): self
    {
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($data)) {
            throw new InvalidArgumentException('Invalid JSON data provided.');
        }

        if (!isset($data['IDPLANTILLA'], $data['NOMBRE_SERVICE'], $data['CLAVEPLANTILLA'])) {
            throw new InvalidArgumentException('Missing required fields in JSON data.');
        }

        /** @var array{IDPLANTILLA: int, NOMBRE_SERVICE: string, CLAVEPLANTILLA: string} $data */
        return self::fromArray($data);
    }
}
