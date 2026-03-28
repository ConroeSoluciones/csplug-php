<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Auth;

use Csfacturacion\CsPlug\Auth\AuthStrategyFactory;
use Csfacturacion\CsPlug\Auth\BasicAuthStrategy;
use Csfacturacion\CsPlug\Auth\BearerAuthStrategy;
use Csfacturacion\CsPlug\Model\AuthMode;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\Test\CsPlug\TestCase;
use Override;

/**
 * Tests for AuthStrategyFactory.
 */
final class AuthStrategyFactoryTest extends TestCase
{
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test that factory creates BasicAuthStrategy for BASIC auth mode.
     */
    public function testCreateReturnsBasicAuthStrategyForBasicMode(): void
    {
        // Arrange
        $config = CsPlugConfig::fromArray([
            'auth_mode' => AuthMode::BASIC->value,
            'username' => 'AAA010101AAA',
            'password' => 'test-password',
        ]);

        // Act
        $strategy = AuthStrategyFactory::create($config);

        // Assert
        $this->assertInstanceOf(BasicAuthStrategy::class, $strategy);
    }

    /**
     * Test that factory creates BearerAuthStrategy for BEARER auth mode.
     */
    public function testCreateReturnsBearerAuthStrategyForBearerMode(): void
    {
        // Arrange
        $config = CsPlugConfig::fromArray([
            'auth_mode' => AuthMode::BEARER->value,
            'bearer_token' => 'test-bearer-token',
        ]);

        // Act
        $strategy = AuthStrategyFactory::create($config);

        // Assert
        $this->assertInstanceOf(BearerAuthStrategy::class, $strategy);
    }

    /**
     * Test that factory defaults to BasicAuthStrategy.
     */
    public function testCreateDefaultsToBasicAuthStrategy(): void
    {
        // Arrange
        $config = CsPlugConfig::fromArray([
            'username' => 'AAA010101AAA',
            'password' => 'test-password',
        ]);

        // Act
        $strategy = AuthStrategyFactory::create($config);

        // Assert
        $this->assertInstanceOf(BasicAuthStrategy::class, $strategy);
    }
}
