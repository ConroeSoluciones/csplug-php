<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Resources;

use Csfacturacion\CsPlug\Contracts\HttpClient;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\DTOs\Requests\SerieRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\SerieResponseDTO;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\HttpResponse;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Resources\SeriesResource;
use Csfacturacion\Test\CsPlug\TestCase;
use JsonException;
use Override;
use PHPUnit\Framework\MockObject\MockObject;

use function json_encode;

use const JSON_THROW_ON_ERROR;

/**
 * Tests for SeriesResource (parent issuer series).
 */
final class SeriesResourceTest extends TestCase
{
    private HttpClient & MockObject $httpClient;
    private RequestFactory & MockObject $requestFactory;
    private SeriesResource $resource;

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
        $this->resource = new SeriesResource(
            $this->httpClient,
            $this->requestFactory,
            $config,
        );
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

    public function testListReturnsPaginatedResponseWithSeries(): void
    {
        $fixture = [
            'message' => 'Exito',
            'data' => [
                [
                    'id_serie' => 13400,
                    'id_emisor' => 660,
                    'id_plantilla' => 78,
                    'serie' => 'TS636',
                    'rango_inicial' => 1,
                    'ruta_logo' => null,
                    'fecha' => '2026-02-19',
                    'tipo' => 1,
                    'config' => null,
                    'status' => null,
                    'version' => '2',
                    'estilo_conceptos' => null,
                    'estilo_totales' => null,
                    'decimales' => 2,
                    'rfc_emisor' => 'AAA010101AAA',
                ],
            ],
            'pagination' => [
                'current_page' => 1,
                'per_page' => 15,
                'total' => 1,
                'last_page' => 1,
            ],
        ];
        $mockResponse = $this->createMockResponse($fixture, 200);

        $mockRequest = new HttpRequest('/series', null, HttpMethod::GET);

        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->willReturn($mockRequest);

        $this->httpClient
            ->expects($this->once())
            ->method('send')
            ->willReturn($mockResponse);

        $result = $this->resource->list();

        $this->assertInstanceOf(PaginatedResponse::class, $result);
        $this->assertCount(1, $result->data);
        $this->assertInstanceOf(SerieResponseDTO::class, $result->data[0]);
        $this->assertSame('TS636', $result->data[0]->serie);
    }

    public function testCreateReturnsSerieResponseDtoOnSuccess(): void
    {
        $fixture = [
            'message' => 'Serie creada',
            'data' => [
                'id_serie' => 13427,
                'id_emisor' => 660,
                'id_plantilla' => 78,
                'serie' => 'TEST_SDK',
                'rango_inicial' => 1,
                'ruta_logo' => null,
                'fecha' => '2026-03-27',
                'tipo' => 1,
                'config' => null,
                'status' => null,
                'version' => '2',
                'estilo_conceptos' => null,
                'estilo_totales' => null,
                'decimales' => 2,
                'rfc_emisor' => 'AAA010101AAA',
            ],
        ];
        $mockResponse = $this->createMockResponse($fixture, 201);

        $serie = (new SerieRequestDTO())
            ->withSerie('TEST_SDK')
            ->withVersion(SerieRequestDTO::VERSION_CFDI)
            ->withTipo(SerieRequestDTO::TIPO_COMPROBANTE_INGRESO)
            ->withClavePlantilla('default');

        $mockRequest = new HttpRequest('/series', $serie, HttpMethod::POST);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->create($serie);

        $this->assertInstanceOf(SerieResponseDTO::class, $result);
        $this->assertSame('TEST_SDK', $result->serie);
    }
}
