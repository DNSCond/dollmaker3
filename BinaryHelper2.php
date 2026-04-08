<?php namespace DataViewed;

use Exception;
use InvalidArgumentException;
use JsonSerializable;
use OutOfBoundsException;

class DataView implements JsonSerializable
{
    protected array $array;

    public function __construct(array|string $array = array())
    {
        if (is_string($array)) {
            $array = self::base64UrlToUint8Array($array);
            if ($array === false) {
                throw new InvalidArgumentException("Invalid base64url string");
            }
        } else {
            foreach ($array as $key => $item) {
                if (is_int($item)) if ($item >= 0 && $item < 256) continue;
                throw new InvalidArgumentException("\$array[$key] sint between 0 and 255 inclusive");
            }
        }
        $this->array = $array;
        $this->fill();
    }

    public function __toString(): string
    {
        return self::uint8ArrayToBase64Url($this->array);
    }

    static function base64UrlToUint8Array($base64Url): false|array
    {
        // 1. Replace URL-safe characters back to standard Base64
        // '-' becomes '+', '_' becomes '/'
        $base64 = strtr($base64Url, '-_', '+/');

        $padding = strlen($base64) % 4;
        if ($padding) {
            $base64 .= str_repeat('=', 4 - $padding);
        }

        // 2. Decode the Base64 string into a raw binary string
        $binaryData = base64_decode($base64);
        if ($binaryData === false) return false;

        // 3. Convert the binary string into an array of integers
        // 'C*' unpacks the string as unsigned chars (0-255)
        $unpacked = unpack('C*', $binaryData);
        if ($unpacked === false) return false;
        return array_values($unpacked);
    }

    static function uint8ArrayToBase64Url(array $uint8Array): array|string
    {
        // 1. Pack the array of integers into a binary string
        // 'C*' treats each array element as an unsigned char (0-255)
        $binaryData = pack('C*', ...$uint8Array);

        // 2. Encode to standard Base64
        $base64 = base64_encode($binaryData);

        // 3. Convert to Base64URL
        // Swap '+' to '-', '/' to '_', and strip the '=' padding
        return str_replace(['+', '/', '='], ['-', '_', ''], $base64);
    }

    public function toBinaryString(): string
    {
        return $this->asBinaryString();
    }

    public function asBinaryString(): string
    {
        //$data = $this->fill()->asArray();

        // If the array is empty, pack('C*', ...[]) returns an empty string,
        // which is correct, but the splat operator on an empty array
        // can sometimes be fussy in older PHP environments.
        //return empty($data) ? '' : pack('C*', ...$data);

        // Alternative for massive arrays
        return pack('C*', ...$this->array);
    }

    public function insertColorRGBAIntToByteArrayAt(int $colorHex, int $offset): void
    {
        self::addColorRGBAIntToByteArrayAt($colorHex, $this->array, $offset);
        $this->fill();
    }

    static function addColorRGBAIntToByteArrayAt(int $colorHex, array &$array, int $offset): void
    {
        // Ensure the value stays within the 24-bit range (0x000000 to 0xFFFFFF)
        // Using max/min is often cleaner than nested if/else for "clamping"
        $color = max(0, min(0xFFFFFF, $colorHex));

        // Extract components using bitwise AND (&)
        // Red: shift 16 bits, Green: shift 8 bits, Blue: mask last 8 bits
        $array[$offset] = ($color >> 16) & 0xFF;
        $array[++$offset] = ($color >> 8) & 0xFF;
        $array[++$offset] = $color & 0xFF;
        // Constant Alpha
        $array[++$offset] = 255;
    }

    function insertUint16toUint8Array(int $uint16, int $offset, bool $littleEndian = true): bool
    {
        $result = self::addUint16toUint8ArrayAt($uint16, $this->array, $offset, $littleEndian);
        $this->fill();
        return $result;
    }

    static function addUint16toUint8ArrayAt(int $uint16, array &$uint8array, int $offset, bool $littleEndian = true): bool
    {
        if ($uint16 < 0 || $uint16 > 0xffff) {
            throw new InvalidArgumentException("Value must be a 16-bit unsigned integer (0-65535).");
        } elseif ($littleEndian) {
            $uint8array[$offset] = $uint16 & 0xff;
            $uint8array[++$offset] = $uint16 >> 8;
        } else {
            $uint8array[$offset++] = $uint16 >> 8;
            $uint8array[$offset] = $uint16 & 0xff;
        }
        return true;
    }

    public function getLength(): int
    {
        if (empty($this->array)) return 0;
        return max(array_keys($this->array)) + 1;
    }

    public function asArray(): false|array
    {
        return $this->array;
    }

    public function getUint16(int $offset, bool $littleEndian = true): int
    {
        if (!isset($this->array[$offset + 1])) {
            throw new OutOfBoundsException("Offset $offset is out of bounds.");
        }
        $b1 = $this->array[$offset];
        $b2 = $this->array[$offset + 1];

        return $littleEndian ? ($b2 << 8) | $b1 : ($b1 << 8) | $b2;
    }

    public function getUint32(int $offset, bool $littleEndian = true): int
    {
        // Bounds check for all 4 bytes
        if (!isset($this->array[$offset + 3])) {
            throw new OutOfBoundsException("Offset $offset for Uint32 is out of bounds.");
        }

        $b1 = $this->array[$offset];
        $b2 = $this->array[$offset + 1];
        $b3 = $this->array[$offset + 2];
        $b4 = $this->array[$offset + 3];

        if ($littleEndian) {
            // Little Endian: b4 is the most significant byte (MSB)
            // b4 << 24 | b3 << 16 | b2 << 8 | b1
            return ($b4 << 24) | ($b3 << 16) | ($b2 << 8) | $b1;
        } else {
            // Big Endian: b1 is the most significant byte (MSB)
            // b1 << 24 | b2 << 16 | b3 << 8 | b4
            return ($b1 << 24) | ($b2 << 16) | ($b3 << 8) | $b4;
        }
    }

    public function getColorAt(int $offset): int
    {
        // Ensure we have 3 bytes to read
        if (!isset($this->array[$offset + 2])) {
            throw new OutOfBoundsException("Offset $offset for RGB is out of bounds.");
        }

        $r = $this->array[$offset];
        $g = $this->array[$offset + 1];
        $b = $this->array[$offset + 2];

        // Shift Red 16 bits, Green 8 bits, and leave Blue at 0 bits
        return ($r << 16) | ($g << 8) | $b;
    }

    public function getUint8(int $offset): int
    {
        if (!isset($this->array[$offset])) {
            throw new OutOfBoundsException("Offset $offset is out of bounds.");
        }
        return $this->array[$offset];
    }

    public function fill(): self
    {
        if (empty($this->array)) return $this;

        // 1. Find the maximum index currently set
        $maxIndex = max(array_keys($this->array));

        // 2. Loop from 0 to the max index
        for ($i = 0; $i <= $maxIndex; $i++) {
            // 3. If the index doesn't exist, set it to 0
            if (!isset($this->array[$i])) {
                $this->array[$i] = 0;
            }
        }

        // 4. Sort by keys to ensure they are in order for the 'pack' function
        ksort($this->array);
        return $this;
    }

    public function jsonSerialize(): array
    {
        return ['u' => "$this", 'data' => $this->asArray()];
    }

    public function toBase58(): string
    {
        return base58_encode($this->toBinaryString());
    }

    static function fromBase58(string $bytes): self
    {
        return new DataView(base58_encode($bytes));
    }
}

//function base58_encode(string $bytes): string
//{
//    $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
//    if ($bytes === '') return '';
//
//    $data = array_values(unpack('C*', $bytes));
//    // Count leading zero bytes
//    $zeroCount = 0;
//    while ($zeroCount < count($data) && $data[$zeroCount] === 0) {
//        $zeroCount++;
//    }
//    $result = '';
//    while (count($data) > 0) {
//        $carry = 0;
//        $next = [];
//        foreach ($data as $byte) {
//            $carry = ($carry << 8) + $byte; // multiply by 256 and add byte
//            $digit = intdiv($carry, 58);
//            $carry %= 58;
//            if (count($next) > 0 || $digit !== 0) {
//                $next[] = $digit;
//            }
//        }
//        $result = $alphabet[$carry] . $result;
//        $data = $next;
//    }
//    return str_repeat('1', $zeroCount) . $result;
//}
function base58_encode(string $bytes): string {
    $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    if ($bytes === '') return '';

    $data = array_values(unpack('C*', $bytes));
    $zeroCount = 0;
    while ($zeroCount < count($data) && $data[$zeroCount] === 0) {
        $zeroCount++;
    }

    $result = '';
    while (count($data) > 0) {
        $carry = 0;
        $next = [];
        foreach ($data as $byte) {
            $carry = $carry * 256 + $byte;
            $digit = intdiv($carry, 58);
            $carry %= 58;
            if (count($next) > 0 || $digit !== 0) {
                $next[] = $digit;
            }
        }
        $result = $alphabet[$carry] . $result;
        $data = $next;
    }

    return str_repeat('1', $zeroCount) . $result;
}
/**
 * @throws Exception
 */
function base58_decode($input): string
{
    $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    $base = strlen($alphabet);

    $num = '0'; // we store the number as a string to avoid integer overflow

    // Convert each character to its numeric value
    $length = strlen($input);
    for ($i = 0; $i < $length; $i++) {
        $char = $input[$i];
        $index = strpos($alphabet, $char);
        if ($index === false) {
            throw new Exception("Invalid Base58 character: $char");
        }

        // Multiply current number by base and add index
        $num = bcmul($num, (string)$base);
        $num = bcadd($num, (string)$index);
    }

    // Convert decimal string to binary string
    $decoded = '';
    while (bccomp($num, '0') > 0) {
        $mod = bcmod($num, '256');
        $decoded = chr((int)$mod) . $decoded;
        $num = bcdiv($num, '256', 0);
    }

    // Add leading zero bytes for each leading '1' in the input
    $nLeadingZeros = 0;
    for ($i = 0; $i < $length && $input[$i] === '1'; $i++) {
        $nLeadingZeros++;
    }

    return str_repeat("\x00", $nLeadingZeros) . $decoded;
}
