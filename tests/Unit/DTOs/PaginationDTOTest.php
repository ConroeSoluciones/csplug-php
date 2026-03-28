<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\DTOs;

use Csfacturacion\CsPlug\DTOs\PaginationDTO;
use Csfacturacion\Test\CsPlug\TestCase;

final class PaginationDTOTest extends TestCase
{
    public function testCanBeCreatedWithDefaults(): void
    {
        $dto = new PaginationDTO();

        $this->assertSame(1, $dto->currentPage);
        $this->assertSame(15, $dto->perPage);
        $this->assertSame(0, $dto->total);
        $this->assertSame(1, $dto->lastPage);
        $this->assertNull($dto->nextPageUrl);
        $this->assertNull($dto->prevPageUrl);
    }

    public function testCanBeCreatedFromArray(): void
    {
        $data = [
            'current_page' => 2,
            'per_page' => 25,
            'total' => 100,
            'last_page' => 4,
            'next_page_url' => 'http://api.test?page=3',
            'prev_page_url' => 'http://api.test?page=1',
        ];

        $dto = PaginationDTO::fromArray($data);

        $this->assertSame(2, $dto->currentPage);
        $this->assertSame(25, $dto->perPage);
        $this->assertSame(100, $dto->total);
        $this->assertSame(4, $dto->lastPage);
        $this->assertSame('http://api.test?page=3', $dto->nextPageUrl);
        $this->assertSame('http://api.test?page=1', $dto->prevPageUrl);
    }

    public function testCanBeConvertedToArray(): void
    {
        $dto = new PaginationDTO(
            currentPage: 2,
            perPage: 25,
            total: 100,
            lastPage: 4,
            nextPageUrl: 'http://api.test?page=3',
            prevPageUrl: 'http://api.test?page=1',
        );

        $array = $dto->toArray();

        $this->assertSame(2, $array['current_page']);
        $this->assertSame(25, $array['per_page']);
        $this->assertSame(100, $array['total']);
        $this->assertSame(4, $array['last_page']);
        $this->assertSame('http://api.test?page=3', $array['next_page_url']);
        $this->assertSame('http://api.test?page=1', $array['prev_page_url']);
    }
}
