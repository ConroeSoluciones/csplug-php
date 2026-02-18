<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit;

use Csfacturacion\CsPlug\CsPlugClient;
use Csfacturacion\CsPlug\Model\AuthMode;
use PHPUnit\Framework\TestCase;

class CsPlugClientTest extends TestCase
{
    public function testCanBeCreatedWithBasicAuth(): void
    {
        $client = CsPlugClient::create([
            'auth_mode' => 'basic',
            'username' => 'user',
            'password' => 'pass'
        ]);

        $this->assertInstanceOf(CsPlugClient::class, $client);
    }

    public function testCanBeCreatedWithBearerAuth(): void
    {
        $client = CsPlugClient::create([
            'auth_mode' => 'bearer',
            'bearer_token' => 'token123',
            'x_rfc' => 'ABC123456T1'
        ]);

        $this->assertInstanceOf(CsPlugClient::class, $client);
    }
}
