<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

class Uuid4 extends AbstractUuid
{
    /**
     * @see https://stackoverflow.com/a/15875555
     */
    protected static function generateBinary(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set variant to RFC4122
        return $data;
    }
}
