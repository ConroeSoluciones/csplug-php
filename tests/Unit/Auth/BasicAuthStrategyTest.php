<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Auth;

use Csfacturacion\CsPlug\Auth\BasicAuthStrategy;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\Test\CsPlug\TestCase;
use Override;

use function base64_encode;

/**
 * Tests for BasicAuthStrategy.
 */
final class BasicAuthStrategyTest extends TestCase
{
    private BasicAuthStrategy $strategy;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $config = CsPlugConfig::fromArray([
            'username' => 'AAA010101AAA',
            'password' => 'test-password',
        ]);
        $this->strategy = new BasicAuthStrategy($config);
    }

    /**
     * Test that getAuthorizationHeader returns base64 encoded credentials.
     */
    public function testGetAuthorizationHeaderReturnsBase64EncodedCredentials(): void
    {
        // Arrange
        $expected = base64_encode('AAA010101AAA:test-password');

        // Act
        $result = $this->strategy->getAuthorizationHeader();

        // Assert
        $this->assertSame($expected, $result);
    }

    /**
     * Test that getAdditionalHeaders returns empty array for basic auth.
     */
    public function testGetAdditionalHeadersReturnsEmptyArray(): void
    {
        // Act
        $result = $this->strategy->getAdditionalHeaders();

        // Assert
        $this->assertSame([], $result);
    }

    /**
     * Test that getAdditionalHeaders returns empty array even with options.
     */
    public function testGetAdditionalHeadersReturnsEmptyArrayWithOptions(): void
    {
        // Arrange
        $options = new RequestOptions();

        // Act
        $result = $this->strategy->getAdditionalHeaders($options);

        // Assert
        $this->assertSame([], $result);
    }
}
