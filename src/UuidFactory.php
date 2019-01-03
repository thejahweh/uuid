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
    /** @var callable */
    private $classMapper;

    public function __construct(callable $classMapper = null)
    {
        $this->classMapper = $classMapper ?? [static::class, 'getClass'];
    }

    public function fromBinary(string $binary): AbstractUuid
    {
        AbstractUuid::checkBinaryValidity($binary);
        $version = AbstractUuid::getBinaryVersion($binary);
        $class = ($this->classMapper)($version);
        return new $class($binary);
    }

    public function fromString(string $string): AbstractUuid
    {
        return $this->fromBinary(self::stringToBinary($string));
    }

    private static function getClass(int $version): string
    {
        $class = static::CLASS_MAP[$version] ?? null;
        if ($class) {
            return $class;
        }
        throw new \Exception("Uuid class for version '$version' not found");
    }

    private static function stringToBinary(string $string): string
    {
        return pack('H*', str_replace('-', '', $string));
    }
}
