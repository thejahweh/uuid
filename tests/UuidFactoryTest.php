<?php
declare(strict_types=1);

namespace Jahweh\Uuid\Test;

use Jahweh\Uuid\Uuid4;
use Jahweh\Uuid\UuidFactory;
use PHPUnit\Framework\TestCase;

final class UuidFactoryTest extends TestCase
{
    public function testFromBinary(): void
    {
        $factory = new UuidFactory();
        $uuid = $factory->fromBinary(hex2bin('5735459897d24ed8927b3bc9e24600b3'));
        $this->assertEquals('57354598-97d2-4ed8-927b-3bc9e24600b3', (string)$uuid);
        $this->assertInstanceOf(Uuid4::class, $uuid);
    }

    public function testFromString(): void
    {
        $factory = new UuidFactory();
        $uuid = $factory->fromString('57354598-97d2-4ed8-927b-3bc9e24600b3');
        $this->assertEquals(hex2bin('5735459897d24ed8927b3bc9e24600b3'), (string)$uuid->getBinary());
        $this->assertInstanceOf(Uuid4::class, $uuid);
    }

    public function testFromStringExceptionClassForVersionNotFound(): void
    {
        $factory = new UuidFactory();
        $this->expectException(\Exception::class);
        $factory->fromString('57354598-97d2-fed8-927b-3bc9e24600b3');
    }

    public function testFromStringExceptionTooLong(): void
    {
        $factory = new UuidFactory();
        $this->expectException(\Exception::class);
        $factory->fromString('57354598-97d2-4ed8-927b-3bc9e24600b33');
    }

    public function testFromStringExceptionTooShort(): void
    {
        $factory = new UuidFactory();
        $this->expectException(\Exception::class);
        $factory->fromString('57354598-97d2-4ed8-927b-3bc9e24600b');
    }

    public function testFromStringExceptionInvalidChar(): void
    {
        $factory = new UuidFactory();
        $this->expectException(\Exception::class);
        $factory->fromString('57354598-97d2-4ed8-927b-3bc9e24600bZ');
    }
}
