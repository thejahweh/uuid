<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

class Uuid4 extends AbstractUuid
{
    protected function getVersionConstant(): int
    {
        return 4;
    }

    /**
     * @see https://stackoverflow.com/a/15875555
     */
    private static function generateBinary(): string
    {
        $data = random_bytes(16);
        static::setBinaryVersion($data, 4);
        static::setBinaryVariant($data);
        return $data;
    }

    public static function generate(): self
    {
        return new static(static::generateBinary());
    }
}
