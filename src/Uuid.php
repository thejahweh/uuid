<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

abstract class Uuid
{
    /** @var string */
    private $binary;

    public function __construct(string $binary)
    {
        if (strlen($binary) !== 16) {
            throw new \Exception('Binary UUID must have 128 bits.');
        }
        $this->binary = $binary;
    }

    abstract protected static function generateBinary(): string;

    final public function getBinary(): string
    {
        return $this->binary;
    }

    final public function getVersion(): int
    {
        return ord($this->binary[6]) >> 4;
    }

    final public function __toString(): string
    {
        return self::binaryToString($this->binary);
    }

    final public static function generate(): self
    {
        return new static(static::generateBinary());
    }

    final private static function binaryToString($binary): string
    {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($binary), 4));
    }
}
