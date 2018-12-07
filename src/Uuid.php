<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

class Uuid
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

    public function getBinary(): string
    {
        return $this->binary;
    }

    public function getVersion(): int
    {
        return ord($this->binary[6]) >> 4;
    }

    public function __toString(): string
    {
        return self::binaryToString($this->binary);
    }

    public static function fromString($string)
    {
        return new self(self::stringToBinary($string));
    }

    public static function uuid4(): self
    {
        return new self(self::generateBinaryUuid4());
    }

    /**
     * @see https://stackoverflow.com/a/15875555
     */
    private static function generateBinaryUuid4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set variant to RFC4122
        return $data;
    }

    private static function binaryToString($binary): string
    {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($binary), 4));
    }

    private static function stringToBinary($string): string
    {
        return pack('H*', str_replace('-', '', $string));
    }
}
