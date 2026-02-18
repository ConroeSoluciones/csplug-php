<?php
declare(strict_types=1);

namespace Csfacturacion\Test\CsPlug;
use JsonException;
use Ramsey\Dev\Tools\TestCase as BaseTestCase;
use RuntimeException;

use function file_exists;
use function file_get_contents;
use function json_decode;

use const JSON_THROW_ON_ERROR;
class TestCase extends BaseTestCase
{

}