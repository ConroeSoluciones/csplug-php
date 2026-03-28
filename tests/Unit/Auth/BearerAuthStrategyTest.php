<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Auth;

use Csfacturacion\CsPlug\Auth\BearerAuthStrategy;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\RequestOptions;
use Csfacturacion\Test\CsPlug\TestCase;
use Override;

/**
 * Tests for BearerAuthStrategy.
 */
final class BearerAuthStrategyTest extends TestCase
{
    private BearerAuthStrategy $strategy;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $config = CsPlugConfig::fromArray([
            'auth_mode' => 'bearer',
            'bearer_token' => 'test-bearer-token',
            'contract_id' => 'AAA010101AAA',
        ]);
        $this->strategy = new BearerAuthStrategy($config);
    }

    /**
     * Test that getAuthorizationHeader returns Bearer token format.
     */
    public function testGetAuthorizationHeaderReturnsBearerTokenFormat(): void
    {
        // Act
        $result = $this->strategy->getAuthorizationHeader();

        // Assert
        $this->assertSame('Bearer test-bearer-token', $result);
    }

    /**
     * Test that getAdditionalHeaders returns X-Rfc header from config.
     */
    public function testGetAdditionalHeadersReturnsXRfcHeaderFromConfig(): void
    {
        // Act
        $result = $this->strategy->getAdditionalHeaders();

        // Assert
        $this->assertSame(['X-Rfc' => 'AAA010101AAA'], $result);
    }

    /**
     * Test that getAdditionalHeaders returns X-Rfc header from options when provided.
     */
    public function testGetAdditionalHeadersReturnsXRfcHeaderFromOptions(): void
    {
        // Arrange
        $options = new RequestOptions();
        $options = $options->withContractId('CUSTOM_RFC_123');

        // Act
        $result = $this->strategy->getAdditionalHeaders($options);

        // Assert
        $this->assertSame(['X-Rfc' => 'CUSTOM_RFC_123'], $result);
    }
}
