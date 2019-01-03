<?php
declare(strict_types=1);

namespace Jahweh\Uuid;

class Uuid1 extends AbstractUuid
{
    /**
     * Is the number of 100-ns intervals between the
     * UUID epoch 1582-10-15 00:00:00 and the Unix epoch 1970-01-01 00:00:00.
     * @var int
     */
    const UUID_UNIX_EPOCH_100NS = 0x01b21dd213814000;

    protected function getVersionConstant(): int
    {
        return 1;
    }

    /**
     * @see https://stackoverflow.com/a/3795750
     * @see https://github.com/webpatser/laravel-uuid/blob/master/src/Webpatser/Uuid/Uuid.php
     */
    private static function generateBinary(?string $node = null): string
    {
        // UUID time
        $time = (int)round(microtime(true) * 1e7 + self::UUID_UNIX_EPOCH_100NS);
        // To Binary
        $time = pack('H*', str_pad(dechex($time), 16, '0', STR_PAD_LEFT));
        // If node is null generate a random one and set the multicast bit
        if ($node === null || strlen($node) !== 6) {
            $node = random_bytes(6);
            $node[0] = chr(ord($node[0]) | 1);
        }
        // Reorder bytes to their proper locations in the UUID
        $data = implode('', [
            'time_low' => $time[4] . $time[5] . $time[6] . $time[7],
            'time_mid' => $time[2] . $time[3],
            'time_high_and_version' => $time[0] . $time[1],
            'clock_seq_high_and_reserved' => random_bytes(1),
            'clock_seq_low' => random_bytes(1),
            'node' => $node,
        ]);
        static::setBinaryVersion($data, 1);
        static::setBinaryVariant($data);
        return $data;
    }

    public static function generate(?string $node = null): self
    {
        return new static(static::generateBinary($node));
    }
}
