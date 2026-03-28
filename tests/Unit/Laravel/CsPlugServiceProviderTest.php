<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Laravel;

use Csfacturacion\Test\CsPlug\TestCase;

/**
 * Laravel integration tests.
 * These require Laravel to be installed.
 *
 * @requires function \Illuminate\Support\ServiceProvider::class
 */
final class CsPlugServiceProviderTest extends TestCase
{
    public function testLaravelIntegrationPlaceholder(): void
    {
        $this->markTestSkipped('Laravel integration tests require Laravel framework to be installed');
    }
}
