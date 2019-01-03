<?php
declare(strict_types=1);

namespace Jahweh\Uuid\Test;

use Jahweh\Uuid\AbstractUuid;
use Jahweh\Uuid\UuidFactory;
use PHPUnit\Framework\TestCase;

final class UuidFactoryTest extends TestCase
{
    public function testFromBinary(): void
    {
        $factory = new UuidFactory(function () {
            return $this->createPartialMock(AbstractUuid::class, []);
        });
        $data = str_repeat(chr(0), 16);
        $uuid = $factory->fromBinary($data);
        $this->assertEquals('00000000-0000-0000-0000-000000000000', (string)$uuid);
    }
}
