<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

class UuidFactory
{
    const CLASS_MAP = [
        4 => Uuid4::class,
    ];
    /** @var string[] */
    private $classMap;

    public function __construct($classMap = self::CLASS_MAP)
    {
        $this->classMap = $classMap;
    }

    public function fromBinary(string $binary): Uuid
    {
        $version = self::getVersion($binary);
        $class = $this->getClass($version);
        return new $class($binary);
    }

    public function fromString(string $string): Uuid
    {
        return $this->fromBinary(self::stringToBinary($string));
    }

    private function getClass(int $version): string
    {
        $class = $this->classMap[$version] ?? null;
        if ($class) {
            return $class;
        }
        throw new \Exception("Uuid class for version '$version' not found");
    }

    private static function stringToBinary(string $string): string
    {
        return pack('H*', str_replace('-', '', $string));
    }

    private static function getVersion(string $binary): int
    {
        return ord($binary[6]) >> 4;
    }
}
