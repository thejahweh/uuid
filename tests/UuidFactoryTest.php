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
        $uuid = $factory->fromBinary(hex2bin('5735459897d24ed8927b3bc9e24600b3'));
        $this->assertEquals('57354598-97d2-4ed8-927b-3bc9e24600b3', (string)$uuid);
    }

    public function testFromString(): void
    {
        $factory = new UuidFactory(function () {
            return $this->createPartialMock(AbstractUuid::class, []);
        });
        $uuid = $factory->fromString('57354598-97d2-4ed8-927b-3bc9e24600b3');
        $this->assertEquals(hex2bin('5735459897d24ed8927b3bc9e24600b3'), (string)$uuid->getBinary());
    }
}
