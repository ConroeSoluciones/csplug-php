<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\DTOs;

use Csfacturacion\CsPlug\DTOs\Requests\CertificadoRequestDTO;
use Csfacturacion\CsPlug\DTOs\Requests\SerieRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\CertificadoResponseDTO;
use Csfacturacion\CsPlug\DTOs\Responses\SerieResponseDTO;
use Csfacturacion\Test\CsPlug\TestCase;
use InvalidArgumentException;

final class CertificadoYSerieDTOTest extends TestCase
{
    // CertificadoRequestDTO Tests
    public function testCertificadoRequestDTOCanBeBuilt(): void
    {
        $dto = (new CertificadoRequestDTO())
            ->withCer('base64cer')
            ->withKey('base64key')
            ->withPassword('test123')
            ->build();

        $this->assertSame('base64cer', $dto->getCer());
        $this->assertSame('base64key', $dto->getKey());
        $this->assertSame('test123', $dto->getPassword());
    }

    public function testCertificadoRequestDTOValidatesCerNotEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Certificate (cer) cannot be empty');

        (new CertificadoRequestDTO())->withCer('');
    }

    public function testCertificadoRequestDTOValidatesKeyNotEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Private key cannot be empty');

        (new CertificadoRequestDTO())->withKey('');
    }

    public function testCertificadoRequestDTOValidatesPasswordNotEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password cannot be empty');

        (new CertificadoRequestDTO())->withPassword('');
    }

    public function testCertificadoRequestDTOValidatesAllFieldsPresent(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Certificate (cer), private key (key), and password are required');

        (new CertificadoRequestDTO())
            ->withCer('base64cer')
            ->withKey('base64key')
            ->build();
    }

    public function testCertificadoResponseDTOCanBeCreatedFromArray(): void
    {
        $data = [
            'id_cert_sello' => 9149,
            'id_emisor' => 660,
            'cer' => 'MIIFgz...',
            'serie_certificado' => '30001000000400002335',
            'inicio_vigencia' => 'May 29 14:50:01 2019 GMT',
            'fin_vigencia' => 'May 29 14:50:01 2023 GMT',
            'password_key' => '12345678a',
            'pem' => '-----BEGIN PRIVATE KEY-----\n...',
            'fecha' => '2023-05-25',
            'tipo' => 0,
            'tipo_certificado' => 1,
            'status' => null,
            'url' => null,
            'fecha_inicial' => '2019-05-29 14:50:01',
            'fecha_final' => '2023-05-29 14:50:01',
            'rfc_emisor' => 'AAA010101AAA',
        ];

        $dto = CertificadoResponseDTO::fromArray($data);

        $this->assertSame(9149, $dto->idCertSello);
        $this->assertSame(660, $dto->idEmisor);
        $this->assertSame('30001000000400002335', $dto->serieCertificado);
        $this->assertSame('AAA010101AAA', $dto->rfcEmisor);
    }

    // SerieRequestDTO Tests
    public function testSerieRequestDTOCanBeBuiltForCFDI(): void
    {
        $dto = (new SerieRequestDTO())
            ->withSerie('TEST_SERIE')
            ->withVersion(SerieRequestDTO::VERSION_CFDI)
            ->withTipo(SerieRequestDTO::TIPO_COMPROBANTE_INGRESO)
            ->withClavePlantilla('default')
            ->withRangoInicial(1)
            ->build();

        $this->assertSame('TEST_SERIE', $dto->getSerie());
        $this->assertSame(SerieRequestDTO::VERSION_CFDI, $dto->getVersion());
        $this->assertSame(SerieRequestDTO::TIPO_COMPROBANTE_INGRESO, $dto->getTipo());
        $this->assertSame('default', $dto->getClavePlantilla());
    }

    public function testSerieRequestDTOCanBeBuiltForRetenciones(): void
    {
        $dto = (new SerieRequestDTO())
            ->withSerie('RET_SERIE')
            ->withVersion(SerieRequestDTO::VERSION_RETENCIONES)
            ->withRangoInicial(1)
            ->build();

        $this->assertSame('RET_SERIE', $dto->getSerie());
        $this->assertSame(SerieRequestDTO::VERSION_RETENCIONES, $dto->getVersion());
        $this->assertNull($dto->getTipo()); // Tipo not required for retenciones
    }

    public function testSerieRequestDTOValidatesSerieNotEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Series name cannot be empty');

        (new SerieRequestDTO())->withSerie('');
    }

    public function testSerieRequestDTOValidatesVersion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Version must be CFDI or RETENCIONES');

        (new SerieRequestDTO())->withVersion('99');
    }

    public function testSerieRequestDTOValidatesTipo(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo must be I (Ingreso), E (Egreso), N (Nomina), or P (Pago)');

        (new SerieRequestDTO())->withTipo('99');
    }

    public function testSerieRequestDTORequiresTipoForCFDI(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo is required for CFDI series');

        (new SerieRequestDTO())
            ->withSerie('TEST')
            ->withVersion(SerieRequestDTO::VERSION_CFDI)
            ->build();
    }

    public function testSerieResponseDTOCanBeCreatedFromArray(): void
    {
        $data = [
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
        ];

        $dto = SerieResponseDTO::fromArray($data);

        $this->assertSame(13427, $dto->idSerie);
        $this->assertSame(660, $dto->idEmisor);
        $this->assertSame('TEST_SDK', $dto->serie);
        $this->assertSame(2, $dto->decimales);
        $this->assertSame('AAA010101AAA', $dto->rfcEmisor);
    }
}
