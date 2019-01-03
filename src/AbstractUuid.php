<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

abstract class AbstractUuid
{
    /** @var string */
    private $binary;

    public function __construct(string $binary)
    {
        static::checkBinaryValidity($binary);
        $this->binary = $binary;
    }

    final public function getBinary(): string
    {
        return $this->binary;
    }

    final public function getVersion(): int
    {
        return static::getBinaryVersion($this->binary);
    }

    final public function __toString(): string
    {
        return self::binaryToString($this->binary);
    }

    public static function checkBinaryValidity(string $binary)
    {
        if (strlen($binary) !== 16) {
            throw new \Exception('Binary UUID must have 128 bits.');
        }
    }

    public static function getBinaryVersion(string $binary): int
    {
        return ord($binary[6]) >> 4;
    }

    private static function binaryToString($binary): string
    {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($binary), 4));
    }
}
