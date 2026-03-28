<?php

declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug\Unit\DTOs;

use Csfacturacion\CsPlug\DTOs\Requests\EmisorHijoRequestDTO;
use Csfacturacion\CsPlug\DTOs\Responses\EmisorHijoResponseDTO;
use Csfacturacion\CsPlug\DTOs\Responses\EmisoresHijosListResponseDTO;
use Csfacturacion\Test\CsPlug\TestCase;
use InvalidArgumentException;
use JsonException;

use function json_decode;
use function json_encode;

use const JSON_THROW_ON_ERROR;

final class EmisorHijoDTOTest extends TestCase
{
    public function testRequestDTOCanBeBuiltWithRequiredFields(): void
    {
        $dto = (new EmisorHijoRequestDTO())
            ->withRfc('MOGI961108JH1')
            ->withRazonSocial('Ivan Montero')
            ->withDomicilioFiscal('91760')
            ->build();

        $this->assertSame('MOGI961108JH1', $dto->getRfc());
        $this->assertSame('Ivan Montero', $dto->getRazonSocial());
        $this->assertSame('91760', $dto->getDomicilioFiscal());
    }

    public function testRequestDTOValidatesRfc(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('RFC cannot be empty');

        (new EmisorHijoRequestDTO())->withRfc('');
    }

    public function testRequestDTOValidatesRfcFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid RFC format');

        (new EmisorHijoRequestDTO())->withRfc('INVALID');
    }

    public function testRequestDTOValidatesRazonSocialNotEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Razon social cannot be empty');

        (new EmisorHijoRequestDTO())->withRazonSocial('');
    }

    public function testRequestDTOCanIncludeConfiguracion(): void
    {
        $config = ['CIEC' => 'test-key', 'automatizacion:csf' => true];
        $dto = (new EmisorHijoRequestDTO())
            ->withRfc('MOGI961108JH1')
            ->withRazonSocial('Ivan Montero')
            ->withDomicilioFiscal('91760')
            ->withConfiguracion($config)
            ->build();

        $this->assertSame($config, $dto->getConfiguracion());
    }

    /**
     * @throws JsonException
     */
    public function testRequestDTOCanBeSerializedToJson(): void
    {
        $dto = (new EmisorHijoRequestDTO())
            ->withRfc('MOGI961108JH1')
            ->withRazonSocial('Ivan Montero')
            ->withDomicilioFiscal('91760')
            ->build();

        $json = json_encode($dto, JSON_THROW_ON_ERROR);
        /** @var array<string, mixed> $data */
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame('MOGI961108JH1', $data['rfc']);
        $this->assertSame('Ivan Montero', $data['razon_social']);
        $this->assertSame('91760', $data['domicilio_fiscal']);
    }

    public function testResponseDTOCanBeCreatedFromArray(): void
    {
        $data = [
            'id_emisor_hijo' => 35,
            'id_emisor' => 660,
            'rfc' => 'MOGI961108JH1',
            'identificacion' => null,
            'razon_social' => 'Ivan Montero Gonzalez',
            'domicilio_fiscal' => '91760',
            'configuracion' => ['CIEC' => 'test'],
        ];

        $dto = EmisorHijoResponseDTO::fromArray($data);

        $this->assertSame(35, $dto->idEmisorHijo);
        $this->assertSame(660, $dto->idEmisor);
        $this->assertSame('MOGI961108JH1', $dto->rfc);
        $this->assertSame('Ivan Montero Gonzalez', $dto->razonSocial);
        $this->assertSame('91760', $dto->domicilioFiscal);
        $this->assertSame(['CIEC' => 'test'], $dto->configuracion);
    }

    public function testResponseDTOSupportsUppercaseKeys(): void
    {
        $data = [
            'ID_EMISOR_HIJO' => 35,
            'ID_EMISOR' => 660,
            'RFC' => 'MOGI961108JH1',
            'RAZONSOCIAL' => 'Ivan Montero',
            'DOMICILIOFISCAL' => '91760',
        ];

        $dto = EmisorHijoResponseDTO::fromArray($data);

        $this->assertSame('MOGI961108JH1', $dto->rfc);
        $this->assertSame('Ivan Montero', $dto->razonSocial);
    }

    public function testListResponseDTOCanBeCreatedFromArray(): void
    {
        $data = [
            'message' => 'Exito',
            'data' => [
                [
                    'id_emisor_hijo' => 35,
                    'id_emisor' => 660,
                    'rfc' => 'MOGI961108JH1',
                    'razon_social' => 'Ivan Montero',
                    'domicilio_fiscal' => '91760',
                ],
            ],
            'pagination' => [
                'current_page' => 1,
                'per_page' => 15,
                'total' => 1,
            ],
        ];

        $dto = EmisoresHijosListResponseDTO::fromArray($data);

        $this->assertSame('Exito', $dto->message);
        $this->assertCount(1, $dto->items);
        $this->assertSame(1, $dto->pagination->currentPage);
    }
}
