<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Resources;

use Csfacturacion\CsPlug\Contracts\HttpClient;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\DTOs\Requests\SerieConfigRequestDTO;
use Csfacturacion\CsPlug\DTOs\Requests\SerieRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\SerieConfigResponseDTO;
use Csfacturacion\CsPlug\DTOs\Responses\SerieResponseDTO;
use Csfacturacion\CsPlug\Error\NotFound;
use Csfacturacion\CsPlug\Error\Unauthorized;
use Csfacturacion\CsPlug\Error\Validation;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\HttpResponse;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Resources\SeriesEmisorHijoResource;
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
 * Tests for SeriesEmisorHijoResource.
 */
final class SeriesEmisorHijoResourceTest extends TestCase
{
    private HttpClient & MockObject $httpClient;
    private RequestFactory & MockObject $requestFactory;
    private SeriesEmisorHijoResource $resource;

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
        $this->resource = new SeriesEmisorHijoResource(
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
        $path = __DIR__ . '/../../_files/fixtures/series-emisor-hijo/' . $name . '.json';
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

    // TESTS FOR list()

    public function testListReturnsPaginatedResponseWithSeries(): void
    {
        $fixture = $this->loadFixture('list_success');
        $mockResponse = $this->createMockResponse($fixture, 200);
        $mockRequest = new HttpRequest('/emisores-hijos/AAA010101AAA/series', null, HttpMethod::GET);

        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->willReturn($mockRequest);

        $this->httpClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($mockResponse);

        $result = $this->resource->list('AAA010101AAA');

        $this->assertInstanceOf(PaginatedResponse::class, $result);
    }

    public function testListThrowsUnauthorizedOn401(): void
    {
        $fixture = $this->loadFixture('list_success');
        $mockResponse = $this->createMockResponse($fixture, 401);
        $mockRequest = new HttpRequest('/emisores-hijos/AAA010101AAA/series', null, HttpMethod::GET);

        $this->requestFactory->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->method('send')->willReturn($mockResponse);

        $this->expectException(Unauthorized::class);
        $this->resource->list('AAA010101AAA');
    }

    // TESTS FOR create()

    public function testCreateReturnsSerieResponseDtoOnSuccess(): void
    {
        $fixture = $this->loadFixture('create_success');
        $mockResponse = $this->createMockResponse($fixture, 201);

        $serieRequest = (new SerieRequestDTO())
            ->withSerie('TEST_SDK')
            ->withVersion(SerieRequestDTO::VERSION_CFDI)
            ->withTipo(SerieRequestDTO::TIPO_COMPROBANTE_INGRESO)
            ->withClavePlantilla('default');

        $mockRequest = new HttpRequest('/emisores-hijos/AAA010101AAA/series', $serieRequest, HttpMethod::POST);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->create('AAA010101AAA', $serieRequest);

        $this->assertInstanceOf(SerieResponseDTO::class, $result);
        $this->assertSame('TEST_SDK', $result->serie);
    }

    public function testCreateThrowsValidationExceptionOn422(): void
    {
        $fixture = ['message' => 'Validation failed', 'errors' => ['serie' => ['El campo serie es requerido']]];
        $mockResponse = $this->createMockResponse($fixture, 422);

        $serieRequest = (new SerieRequestDTO())
            ->withSerie('TEST_SDK')
            ->withVersion(SerieRequestDTO::VERSION_CFDI)
            ->withTipo(SerieRequestDTO::TIPO_COMPROBANTE_INGRESO);

        $mockRequest = new HttpRequest('/emisores-hijos/AAA010101AAA/series', $serieRequest, HttpMethod::POST);

        $this->requestFactory->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->method('send')->willReturn($mockResponse);

        $this->expectException(Validation::class);
        $this->resource->create('AAA010101AAA', $serieRequest);
    }

    // TESTS FOR update()

    public function testUpdateReturnsSerieResponseDtoOnSuccess(): void
    {
        $fixture = $this->loadFixture('update_success');
        $mockResponse = $this->createMockResponse($fixture, 200);

        $serieRequest = (new SerieRequestDTO())
            ->withSerie('TEST_SDK_UPDATED')
            ->withVersion(SerieRequestDTO::VERSION_CFDI)
            ->withTipo(SerieRequestDTO::TIPO_COMPROBANTE_INGRESO)
            ->withClavePlantilla('default');

        $rfc = 'AAA010101AAA';
        $idSerie = 13427;
        $mockRequest = new HttpRequest("/emisores-hijos/{$rfc}/series/{$idSerie}", $serieRequest, HttpMethod::PUT);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->update($rfc, $idSerie, $serieRequest);

        $this->assertInstanceOf(SerieResponseDTO::class, $result);
        $this->assertSame('TEST_SDK_UPDATED', $result->serie);
    }

    public function testUpdateThrowsNotFoundOn404(): void
    {
        $fixture = $this->loadFixture('error_404');
        $mockResponse = $this->createMockResponse($fixture, 404);

        $serieRequest = (new SerieRequestDTO())
            ->withSerie('TEST_SDK')
            ->withVersion(SerieRequestDTO::VERSION_CFDI)
            ->withTipo(SerieRequestDTO::TIPO_COMPROBANTE_INGRESO);

        $mockRequest = new HttpRequest('/emisores-hijos/AAA010101AAA/series/99999', $serieRequest, HttpMethod::PUT);

        $this->requestFactory->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->method('send')->willReturn($mockResponse);

        $this->expectException(NotFound::class);
        $this->resource->update('AAA010101AAA', 99999, $serieRequest);
    }

    // TESTS FOR configure()

    public function testConfigureReturnsConfigResponseDtoOnSuccess(): void
    {
        $fixture = $this->loadFixture('config_success');
        $mockResponse = $this->createMockResponse($fixture, 200);

        $configRequest = (new SerieConfigRequestDTO())
            ->withTemplate('default')
            ->withOrientation(SerieConfigRequestDTO::ORIENTATION_LANDSCAPE)
            ->withAccentColor('#FF5733')
            ->withFontColor('#333333');

        $rfc = 'AAA010101AAA';
        $idSerie = 13427;
        $mockRequest = new HttpRequest(
            "/emisores-hijos/{$rfc}/series/{$idSerie}/config",
            $configRequest,
            HttpMethod::POST,
        );

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->configure($rfc, $idSerie, $configRequest);

        $this->assertInstanceOf(SerieConfigResponseDTO::class, $result);
        $this->assertSame('landscape', $result->orientation);
        $this->assertSame('#FF5733', $result->accentColor);
    }

    public function testConfigureThrowsValidationExceptionOn422(): void
    {
        $fixture = $this->loadFixture('config_error_422');
        $mockResponse = $this->createMockResponse($fixture, 422);

        $configRequest = new SerieConfigRequestDTO();

        $mockRequest = new HttpRequest(
            '/emisores-hijos/AAA010101AAA/series/13427/config',
            $configRequest,
            HttpMethod::POST,
        );

        $this->requestFactory->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->method('send')->willReturn($mockResponse);

        $this->expectException(Validation::class);
        $this->resource->configure('AAA010101AAA', 13427, $configRequest);
    }
}
