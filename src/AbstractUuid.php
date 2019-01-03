<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

abstract class AbstractUuid
{
    const VARIANT_RFC4122 = 0x80;
    /** @var string */
    private $binary;

    public function __construct(string $binary)
    {
        static::checkBinaryValidity($binary);
        $this->binary = $binary;
        // Check version validity
        if ($this->getVersion() !== $this->getVersionConstant()) {
            throw new \Exception(
                "Version '{$this->getVersion()}' does not match expected version '{$this->getVersionConstant()}'."
            );
        }
    }

    abstract protected function getVersionConstant(): int;

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

    public static function checkBinaryValidity(string $binary): void
    {
        if (strlen($binary) !== 16) {
            throw new \Exception('Binary UUID must have 128 bits.');
        }
    }

    public static function getBinaryVersion(string $binary): int
    {
        return ord($binary[6]) >> 4;
    }

    protected static function setBinaryVersion(string &$data, int $version): void
    {
        $data[6] = chr(ord($data[6]) & 0x0f | 0x10 * $version);
    }

    protected static function setBinaryVariant(string &$data, int $variant = self::VARIANT_RFC4122): void
    {
        $data[8] = chr(ord($data[8]) & 0x3f | $variant);
    }

    private static function binaryToString($binary): string
    {
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($binary), 4));
    }
}
