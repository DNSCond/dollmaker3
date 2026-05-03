<?php namespace DataViewed;

use Exception;
use InvalidArgumentException;

class BinaryView
{
    protected string $string;

    public function __construct(null|false|int|string $string = '')
    {
        if (is_string($string)) {
            $this->string = $string;
        } elseif (is_int($string) && $string >= 0) {
            $this->string = str_repeat("\x00", $string);
        } elseif ($string === null || $string === false) {
            $this->string = '';
        } else throw new InvalidArgumentException('length must be present');
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function toBase64(): string
    {
        return base64_encode($this->string);
    }

    public function toBase64URL(): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($this->string));
    }

    static function fromBase64(string $base64): self
    {
        return new self(base64_decode($base64, true));
    }

    static function fromBase64URL(string $base64Url): self
    {
        $base64 = strtr($base64Url, '-_', '+/');

        $padding = strlen($base64) % 4;
        if ($padding) {
            $base64 .= str_repeat('=', 4 - $padding);
        }
        return self::fromBase64($base64);
    }

    function setUint8(int $offset, int $byte): bool
    {
        if ($byte < 0 || $byte > 0xfF) return false;
        if ($offset > strlen($this->string) || $offset < 0) return false;
        $this->string[$offset] = pack('C', $byte);
        return true;
    }

    function getUint8(int $offset): false|int
    {
        if ($offset > strlen($this->string) || $offset < 0) return false;
        $bytes = substr($this->string, $offset, 1);
        return +unpack('C', $bytes)[1];
    }

    function setUint16(int $offset, int $byte, bool $littleEndian = true): bool
    {
        if ($byte < 0 || $byte > 0xfFfF) return false;
        if ($offset < 0 || $offset + 1 >= strlen($this->string)) return false;
        $packed = pack($littleEndian ? 'v' : 'n', $byte);
        for ($i = 0; $i < 2; $i++) {
            $this->string[$offset + $i] = $packed[$i];
        }
        return true;
    }

    function getUint16(int $offset, bool $littleEndian = true): false|int
    {
        if ($offset + 1 > strlen($this->string) || $offset < 0) return false;
        $bytes = substr($this->string, $offset, 2);
        return +unpack($littleEndian ? 'v' : 'n', $bytes)[1];
    }

    function setUint32(int $offset, int $byte, bool $littleEndian = true): bool
    {
        if ($byte < 0 || $byte > 0xfFfFfFfF) return false;
        if ($offset < 0 || $offset + 3 >= strlen($this->string)) return false;
        $packed = pack($littleEndian ? 'V' : 'N', $byte);
        for ($i = 0; $i < 4; $i++) {
            $this->string[$offset + $i] = $packed[$i];
        }
        return true;
    }

    function getUint32(int $offset, bool $littleEndian = true): false|int
    {
        if ($offset < 0 || $offset + 3 >= strlen($this->string)) return false;
        $bytes = substr($this->string, $offset, 4);
        return +unpack($littleEndian ? 'V' : 'N', $bytes)[1];
    }

    public function getLength(): int
    {
        return strlen($this->string);
    }

    public function asArray(): false|array
    {
        return array_values(unpack('C*', $this->string));
    }

    public function toBase58(): string
    {
        return base58_encode($this->string);
    }

    static function fromBase58(string $bytes): self
    {
        return new self(base58_encode($bytes));
    }
}

function base58_encode(string $bytes): string
{
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


function RGBA32ToRGB(BinaryView $dataview, int $offset): int
{
    $r = $dataview->getUint8($offset);
    $g = $dataview->getUint8(++$offset);
    $b = $dataview->getUint8(++$offset);
    return ($r << 16) | ($g << 8) | $b;
}

function RGBToRGBA32(BinaryView $dataview, int $color, int $offset): void
{
    $dataview->setUint8($offset, ($color >> 16) & 0xFF);
    $dataview->setUint8(++$offset, ($color >> 8) & 0xFF);
    $dataview->setUint8(++$offset, $color & 0xFF);
    $dataview->setUint8(++$offset, 0xFF);
}
