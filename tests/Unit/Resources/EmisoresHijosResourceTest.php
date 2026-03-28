<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Resources;

use Csfacturacion\CsPlug\Contracts\HttpClient;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\DTOs\Requests\EmisorHijoRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\EmisorHijoResponseDTO;
use Csfacturacion\CsPlug\Error\NotFound;
use Csfacturacion\CsPlug\Error\Unauthorized;
use Csfacturacion\CsPlug\Error\Validation;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\HttpResponse;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Resources\EmisoresHijosResource;
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

final class EmisoresHijosResourceTest extends TestCase
{
    private HttpClient & MockObject $httpClient;
    private RequestFactory & MockObject $requestFactory;
    private EmisoresHijosResource $resource;

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
        $this->resource = new EmisoresHijosResource(
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
        $path = __DIR__ . '/../../_files/fixtures/emisores-hijos/' . $name . '.json';
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

    public function testListReturnsPaginatedResponseWithEmisoresHijos(): void
    {
        $fixture = $this->loadFixture('list_success');
        $mockResponse = $this->createMockResponse($fixture, 200);
        $mockRequest = new HttpRequest('/emisores-hijos', null, HttpMethod::GET);

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
        $this->assertCount(2, $result->data);
    }

    public function testListThrowsUnauthorizedOn401(): void
    {
        $fixture = $this->loadFixture('error_401');
        $mockResponse = $this->createMockResponse($fixture, 401);
        $mockRequest = new HttpRequest('/emisores-hijos', null, HttpMethod::GET);

        $this->requestFactory->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->method('send')->willReturn($mockResponse);

        $this->expectException(Unauthorized::class);
        $this->resource->list();
    }

    // TESTS FOR create()

    public function testCreateReturnsEmisorHijoOnSuccess(): void
    {
        $fixture = $this->loadFixture('create_success');
        $mockResponse = $this->createMockResponse($fixture, 201);
        $emisorHijo = (new EmisorHijoRequestDTO())
            ->withRfc('MOGI961108JH1')
            ->withRazonSocial('Test')
            ->withDomicilioFiscal('91760');
        $mockRequest = new HttpRequest('/emisores-hijos', $emisorHijo, HttpMethod::POST);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->create($emisorHijo);

        $this->assertInstanceOf(EmisorHijoResponseDTO::class, $result);
    }

    public function testCreateThrowsValidationExceptionOn422(): void
    {
        $fixture = $this->loadFixture('error_422');
        $mockResponse = $this->createMockResponse($fixture, 422);
        $emisorHijo = (new EmisorHijoRequestDTO())
            ->withRfc('MOGI961108JH1')
            ->withRazonSocial('Test')
            ->withDomicilioFiscal('91760');
        $mockRequest = new HttpRequest('/emisores-hijos', $emisorHijo, HttpMethod::POST);

        $this->requestFactory->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->method('send')->willReturn($mockResponse);

        $this->expectException(Validation::class);
        $this->resource->create($emisorHijo);
    }

    // TESTS FOR update()

    public function testUpdateReturnsEmisorHijoOnSuccess(): void
    {
        $fixture = $this->loadFixture('update_success');
        $mockResponse = $this->createMockResponse($fixture, 200);
        $rfc = 'MOGI961108JH1';
        $emisorHijo = (new EmisorHijoRequestDTO())
            ->withRfc($rfc)
            ->withRazonSocial('Updated')
            ->withDomicilioFiscal('91760');
        $mockRequest = new HttpRequest('/emisores-hijos/' . $rfc, $emisorHijo, HttpMethod::PUT);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->update($rfc, $emisorHijo);

        $this->assertInstanceOf(EmisorHijoResponseDTO::class, $result);
    }

    public function testUpdateThrowsNotFoundOn404(): void
    {
        $fixture = $this->loadFixture('error_404');
        $mockResponse = $this->createMockResponse($fixture, 404);
        $rfc = 'MOGI961108JH1';
        $emisorHijo = (new EmisorHijoRequestDTO())
            ->withRfc($rfc)
            ->withRazonSocial('Test')
            ->withDomicilioFiscal('91760');
        $mockRequest = new HttpRequest('/emisores-hijos/' . $rfc, $emisorHijo, HttpMethod::PUT);

        $this->requestFactory->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->method('send')->willReturn($mockResponse);

        $this->expectException(NotFound::class);
        $this->resource->update($rfc, $emisorHijo);
    }
}
