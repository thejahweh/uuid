<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

class UuidFactory
{
    /** @var string[] */
    const CLASS_MAP = [
        1 => Uuid1::class,
        4 => Uuid4::class,
    ];
    /** @var string[] */
    private $classMap;

    public function __construct($classMap = self::CLASS_MAP)
    {
        $this->classMap = $classMap;
    }

    public function fromBinary(string $binary): AbstractUuid
    {
        AbstractUuid::checkBinaryValidity($binary);
        $version = AbstractUuid::getBinaryVersion($binary);
        $class = $this->getClass($version);
        return new $class($binary);
    }

    public function fromString(string $string): AbstractUuid
    {
        static::checkStringValidity($string);
        return $this->fromBinary(self::stringToBinary($string));
    }

    private function getClass(int $version): string
    {
        $class = $this->classMap[$version] ?? null;
        if ($class) {
            return $class;
        }
        throw new \Exception("Uuid class for version '$version' not found.");
    }

    private static function stringToBinary(string $string): string
    {
        return pack('H*', str_replace('-', '', $string));
    }

    public static function checkStringValidity(string $string): void
    {
        if (preg_match('/^[0-9a-f]{8}-(?:[0-9a-f]{4}-){3}[0-9a-f]{12}$/i', $string) !== 1) {
            throw new \Exception('UUID string is not valid.');
        }
    }
}
