<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\Resources;

use Csfacturacion\CsPlug\Contracts\HttpClient;
use Csfacturacion\CsPlug\Contracts\RequestFactory;
use Csfacturacion\CsPlug\DTOs\Requests\CertificadoRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\CertificadoResponseDTO;
use Csfacturacion\CsPlug\Model\CsPlugConfig;
use Csfacturacion\CsPlug\Model\HttpMethod;
use Csfacturacion\CsPlug\Model\HttpRequest;
use Csfacturacion\CsPlug\Model\HttpResponse;
use Csfacturacion\CsPlug\Model\PaginatedResponse;
use Csfacturacion\CsPlug\Resources\CertificadosResource;
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
 * Tests for CertificadosResource.
 */
final class CertificadosResourceTest extends TestCase
{
    private HttpClient & MockObject $httpClient;
    private RequestFactory & MockObject $requestFactory;
    private CertificadosResource $resource;

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
        $this->resource = new CertificadosResource(
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
        $path = __DIR__ . '/../../_files/fixtures/certificados/' . $name . '.json';
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

    public function testListReturnsPaginatedResponseWithCertificados(): void
    {
        $fixture = $this->loadFixture('list_success');
        $mockResponse = $this->createMockResponse($fixture, 200);

        $mockRequest = new HttpRequest('/certificados', null, HttpMethod::GET);

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
        $this->assertInstanceOf(CertificadoResponseDTO::class, $result->data[0]);
    }

    public function testCreateReturnsCertificadoResponseDtoOnSuccess(): void
    {
        $fixture = $this->loadFixture('create_success');
        $mockResponse = $this->createMockResponse($fixture, 201);

        $certificado = (new CertificadoRequestDTO())
            ->withCer('MIIFgzCCA2ug...base64...')
            ->withKey('MIIFDjBA...base64...')
            ->withPassword('12345678a');

        $mockRequest = new HttpRequest('/certificados', $certificado, HttpMethod::POST);

        $this->requestFactory->expects($this->once())->method('createRequest')->willReturn($mockRequest);
        $this->httpClient->expects($this->once())->method('send')->willReturn($mockResponse);

        $result = $this->resource->create($certificado);

        $this->assertInstanceOf(CertificadoResponseDTO::class, $result);
        $this->assertSame(9181, $result->idCertSello);
    }
}
