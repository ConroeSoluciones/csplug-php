<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Resources;

use Csfacturacion\CsPlug\Contracts\HttpClient;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\DTOs\Requests\CfdiCancelarRequestDTO;
use Csfacturacion\CsPlug\DTOs\Requests\CfdiTimbrarRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\CfdiResponseDTO;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\HttpResponse;
use Csfacturacion\CsPlug\Resources\CfdiResource;
use Csfacturacion\Test\CsPlug\TestCase;
use JsonException;
use Override;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;

use function file_exists;
use function file_get_contents;
use function json_decode;
use function json_encode;

use const JSON_THROW_ON_ERROR;

/**
 * Tests for CfdiResource.
 */
final class CfdiResourceTest extends TestCase
{
    private HttpClient & MockObject $httpClient;
    private RequestFactory & MockObject $requestFactory;
    private CfdiResource $resource;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = $this->createMock(HttpClient::class);
        $this->requestFactory = $this->createMock(RequestFactory::class);
        $config = CsPlugConfig::fromArray([
            'base_uri' => 'https://api.csplug.test',
            'auth_mode' => 'basic',
            'username' => 'AAA010101AAA',
            'password' => 'test-api-key',
        ]);
        $this->resource = new CfdiResource(
            $this->httpClient,
            $this->requestFactory,
            $config,
        );
    }

    /**
     * @return array<string, mixed>
     *
     * @throws JsonException
     */
    private function loadFixture(string $name): array
    {
        $path = __DIR__ . '/../../_files/fixtures/cfdi/' . $name . '.json';
        if (!file_exists($path)) {
            throw new RuntimeException("Fixture not found: {$path}");
        }
        $content = file_get_contents($path);
        if ($content === false) {
            throw new RuntimeException("Failed to read fixture: {$path}");
        }
        /** @var array<string, mixed> $decoded */
        $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return $decoded;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws JsonException
     */
    private function createMockResponse(array $data, int $statusCode): HttpResponse
    {
        return new HttpResponse(
            rawResponse: json_encode($data, JSON_THROW_ON_ERROR),
            code: $statusCode,
            headers: ['Content-Type' => ['application/json']],
        );
    }

    public function testTimbrarReturnsCfdiResponseDtoOnSuccess(): void
    {
        $fixture = $this->loadFixture('timbrar_success');
        $mockResponse = $this->createMockResponse($fixture, 200);

        $comprobante = new CfdiTimbrarRequestDTO([
            'Serie' => 'A',
            'Folio' => '123',
            'Fecha' => '2024-01-15T10:30:00',
            'FormaPago' => '01',
            'SubTotal' => 1000.00,
            'Total' => 1160.00,
            'TipoDeComprobante' => 'I',
        ]);

        $mockRequest = new HttpRequest('/cfdi', $comprobante, HttpMethod::POST);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->timbrar($comprobante);

        $this->assertInstanceOf(CfdiResponseDTO::class, $result);
        $this->assertSame('12345678-1234-1234-1234-123456789012', $result->uuid);
    }

    public function testShowReturnsCfdiResponseDtoOnSuccess(): void
    {
        $fixture = $this->loadFixture('show_success');
        $mockResponse = $this->createMockResponse($fixture, 200);

        $uuid = '12345678-1234-1234-1234-123456789012';
        $mockRequest = new HttpRequest('/cfdi/' . $uuid, null, HttpMethod::GET);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->show($uuid);

        $this->assertInstanceOf(CfdiResponseDTO::class, $result);
        $this->assertSame($uuid, $result->uuid);
    }

    public function testCancelReturnsArrayOnSuccess(): void
    {
        $fixture = $this->loadFixture('cancel_success');
        $mockResponse = $this->createMockResponse($fixture, 200);

        $cancelRequest = new CfdiCancelarRequestDTO(
            uuid: '12345678-1234-1234-1234-123456789012',
            rfcEmisor: 'AAA010101AAA',
        );

        $mockRequest = new HttpRequest('/cfdi/cancelar', $cancelRequest, HttpMethod::POST);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->cancel($cancelRequest);

        $this->assertIsArray($result);
        $this->assertSame('Cancelado', $result['estatus']);
    }

    public function testDemoReturnsCfdiResponseDtoOnSuccess(): void
    {
        $fixture = $this->loadFixture('timbrar_success');
        $mockResponse = $this->createMockResponse($fixture, 200);

        $comprobante = new CfdiTimbrarRequestDTO([
            'Serie' => 'A',
            'Folio' => '123',
            'Fecha' => '2024-01-15T10:30:00',
        ]);

        $mockRequest = new HttpRequest('/demo/cfdi', $comprobante, HttpMethod::POST);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->demo($comprobante);

        $this->assertInstanceOf(CfdiResponseDTO::class, $result);
    }
}
