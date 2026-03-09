<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use JsonException;
use RuntimeException;

use function json_decode;

use const JSON_THROW_ON_ERROR;

final class HttpResponse
{
    /**
     * @param array<string, string|string[]> $headers
     */
    public function __construct(
        private readonly string $rawResponse,
        private readonly int $code,
        private readonly array $headers = [],
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->code >= 200 && $this->code < 300;
    }

    public function getRawResponse(): string
    {
        return $this->rawResponse;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array<string, string|string[]>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param class-string<T> $class
     *
     * @return T|T[]
     *
     * @throws JsonException
     *
     * @template T of Deserializable
     */
    public function bodyAsModel(string $class): Deserializable | array
    {
        /** @var T|T[] $model */
        $model = $class::fromJson($this->rawResponse);

        return $model;
    }

    /**
     * @return array<string, mixed>
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.ReturnTypeHint
    public function bodyAsArray(): array
    {
        try {
            /** @var array<string, mixed> $result */
            $result = (array) json_decode($this->rawResponse, true, 512, JSON_THROW_ON_ERROR);

            return $result;
        } catch (JsonException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
