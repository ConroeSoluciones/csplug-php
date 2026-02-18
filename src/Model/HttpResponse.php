<?php

declare(strict_types=1);

namespace Csfacturacion\CsPlug\Model;

use Csfacturacion\CsPlug\Util\Deserializable;
use JsonException;
use RuntimeException;
final class HttpResponse
{
    public function __construct(
        private readonly string $rawResponse,
        private readonly int $code,
        private readonly array $headers = []
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

    // phpcs:ignore SlevomatCodingStandard.TypeHints.ReturnTypeHint
    public function bodyAsArray(): array // @phpstan-ignore missingType.iterableValue
    {
        try {
            return (array) json_decode($this->rawResponse, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
