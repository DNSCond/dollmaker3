<?php $html_color_names = (function () {
    $initial = ['Black' => '#000000', 'Navy' => '#000080', 'DarkBlue' => '#00008B', 'MediumBlue' => '#0000CD',
        'Blue' => '#0000FF', 'DarkGreen' => '#006400', 'Green' => '#008000', 'Teal' => '#008080',
        'DarkCyan' => '#008B8B', 'DeepSkyBlue' => '#00BFFF', 'DarkTurquoise' => '#00CED1',
        'MediumSpringGreen' => '#00FA9A', 'Lime' => '#00FF00', 'SpringGreen' => '#00FF7F', 'Cyan' => '#00FFFF',
        'MidnightBlue' => '#191970', 'DodgerBlue' => '#1E90FF', 'LightSeaGreen' => '#20B2AA',
        'ForestGreen' => '#228B22', 'SeaGreen' => '#2E8B57', 'DarkSlateGrey' => '#2F4F4F', 'LimeGreen' => '#32CD32',
        'MediumSeaGreen' => '#3CB371', 'Turquoise' => '#40E0D0', 'RoyalBlue' => '#4169E1', 'SteelBlue' => '#4682B4',
        'DarkSlateBlue' => '#483D8B', 'MediumTurquoise' => '#48D1CC', 'Indigo' => '#4B0082',
        'DarkOliveGreen' => '#556B2F', 'CadetBlue' => '#5F9EA0', 'CornflowerBlue' => '#6495ED',
        'RebeccaPurple' => '#663399', 'MediumAquaMarine' => '#66CDAA', 'DimGrey' => '#696969',
        'SlateBlue' => '#6A5ACD', 'OliveDrab' => '#6B8E23', 'SlateGrey' => '#708090', 'LightSlateGrey' => '#778899',
        'MediumSlateBlue' => '#7B68EE', 'LawnGreen' => '#7CFC00', 'Chartreuse' => '#7FFF00',
        'Aquamarine' => '#7FFFD4', 'Maroon' => '#800000', 'Purple' => '#800080', 'Olive' => '#808000',
        'Grey' => '#808080', 'SkyBlue' => '#87CEEB', 'LightSkyBlue' => '#87CEFA', 'BlueViolet' => '#8A2BE2',
        'DarkRed' => '#8B0000', 'DarkMagenta' => '#8B008B', 'SaddleBrown' => '#8B4513', 'DarkSeaGreen' => '#8FBC8F',
        'LightGreen' => '#90EE90', 'MediumPurple' => '#9370DB', 'DarkViolet' => '#9400D3', 'PaleGreen' => '#98FB98',
        'DarkOrchid' => '#9932CC', 'YellowGreen' => '#9ACD32', 'Sienna' => '#A0522D', 'Brown' => '#A52A2A',
        'DarkGrey' => '#A9A9A9', 'LightBlue' => '#ADD8E6', 'GreenYellow' => '#ADFF2F', 'PaleTurquoise' => '#AFEEEE',
        'LightSteelBlue' => '#B0C4DE', 'PowderBlue' => '#B0E0E6', 'FireBrick' => '#B22222',
        'DarkGoldenRod' => '#B8860B', 'MediumOrchid' => '#BA55D3', 'RosyBrown' => '#BC8F8F',
        'DarkKhaki' => '#BDB76B', 'Silver' => '#C0C0C0', 'MediumVioletRed' => '#C71585',
        'IndianRed' => '#CD5C5C', 'Peru' => '#CD853F', 'Chocolate' => '#D2691E', 'Tan' => '#D2B48C',
        'LightGrey' => '#D3D3D3', 'Thistle' => '#D8BFD8', 'Orchid' => '#DA70D6', 'GoldenRod' => '#DAA520',
        'PaleVioletRed' => '#DB7093', 'Crimson' => '#DC143C', 'Gainsboro' => '#DCDCDC', 'Plum' => '#DDA0DD',
        'BurlyWood' => '#DEB887', 'LightCyan' => '#E0FFFF', 'Lavender' => '#E6E6FA', 'DarkSalmon' => '#E9967A',
        'Violet' => '#EE82EE', 'PaleGoldenRod' => '#EEE8AA', 'LightCoral' => '#F08080', 'Khaki' => '#F0E68C',
        'AliceBlue' => '#F0F8FF', 'HoneyDew' => '#F0FFF0', 'Azure' => '#F0FFFF', 'SandyBrown' => '#F4A460',
        'Wheat' => '#F5DEB3', 'Beige' => '#F5F5DC', 'WhiteSmoke' => '#F5F5F5', 'MintCream' => '#F5FFFA',
        'GhostWhite' => '#F8F8FF', 'Salmon' => '#FA8072', 'AntiqueWhite' => '#FAEBD7', 'Linen' => '#FAF0E6',
        'LightGoldenRodYellow' => '#FAFAD2', 'OldLace' => '#FDF5E6', 'Red' => '#FF0000', 'Magenta' => '#FF00FF',
        'DeepPink' => '#FF1493', 'OrangeRed' => '#FF4500', 'Tomato' => '#FF6347', 'HotPink' => '#FF69B4',
        'Coral' => '#FF7F50', 'DarkOrange' => '#FF8C00', 'LightSalmon' => '#FFA07A', 'Orange' => '#FFA500',
        'LightPink' => '#FFB6C1', 'Pink' => '#FFC0CB', 'Gold' => '#FFD700', 'PeachPuff' => '#FFDAB9',
        'NavajoWhite' => '#FFDEAD', 'Moccasin' => '#FFE4B5', 'Bisque' => '#FFE4C4', 'MistyRose' => '#FFE4E1',
        'BlanchedAlmond' => '#FFEBCD', 'PapayaWhip' => '#FFEFD5', 'LavenderBlush' => '#FFF0F5',
        'SeaShell' => '#FFF5EE', 'Cornsilk' => '#FFF8DC', 'LemonChiffon' => '#FFFACD', 'FloralWhite' => '#FFFAF0',
        'Snow' => '#FFFAFA', 'Yellow' => '#FFFF00', 'LightYellow' => '#FFFFE0', 'Ivory' => '#FFFFF0',
        'White' => '#FFFFFF'];
    $return = array();
    foreach ($initial as $key => $value) {
        $return[strtolower($key)] = strtolower($value);
    }
    return ['samecase' => $initial, 'lowercase' => $return];
})();

function pythonMod(float|int $a, float|int $b): float|int
{
    $mod = $a % $b;
    // Adjust the result to have the same sign as the divisor
    if ($mod < 0) {
        $mod += abs($b);
    }
    return $mod;
}

function lclamp(int|float $now, int|float $lower): int|float
{
    return max($now, $lower);
}

function rclamp(int|float $now, int|float $higher): int|float
{
    return min($now, $higher);
}

function clamp(int|float $now, int|float $lower, int|float $higher): int|float
{
    return lclamp(rclamp($now, $higher), $lower);
}

function toString(mixed $any): string
{
    return match ($any) {
        false => 'false',
        true => 'true',
        null => 'null',
        default => (function () use ($any) {
            return match (gettype($any)) {
                'array' => implode(',', $any),
                'double', 'integer', 'object' => "$any",
                'string' => $any,
            };
        })()
    };
}

enum percent_clamp
{
    case Allow_0_1;
    case Allow_0_100;
    case Otherwise;
}

/**
 * @param float $float (range 0 to 1) then returned as is (inclusive, inclusive),
 * (range 1 to 255) then returned divided 100 (exclusive, inclusive).
 * @param percent_clamp $parsetype if percent_clamp::Allow_0_1 then always returned asis,
 * elseif Allow_0_100 then always returned divided 100
 * @return float (range 0 to 1)
 */
function percent_clamp(float $float, percent_clamp $parsetype = percent_clamp::Otherwise): float
{
    if ($float < 0) {
        throw new InvalidArgumentException("\$float ($float) is less than 0");
    } elseif ($float <= 1 || $parsetype === percent_clamp::Allow_0_1) {
        return $float;
    } elseif ($float <= 100 || $parsetype === percent_clamp::Allow_0_100) {
        return $float / 100;
    }
    throw new InvalidArgumentException("\$float ($float) is not between 0 and 100 or 0 to 1");
}

enum toStringColorMode
{
    case RGB;
    case HSL;
}

function cssColorToColorInt(string $color): false|int
{
    // Remove any whitespace and convert to lowercase
    $color = trim(strtolower($color));

    // Check for named colors
    global $html_color_names;
    $namedColors = $html_color_names['lowercase'];

    if (array_key_exists($color, $namedColors)) {
        return hexdec($namedColors[$color]);
    }

    // Check for hex colors
    if (preg_match('/^#?(?:[a-f0-9]{3}|[a-f0-9]{6})$/iD', $color)) {

        // Convert shorthand hex to full hex
        if (strlen($color) == 4) {
            $color = "#$color[1]$color[1]$color[2]$color[2]$color[3]$color[3]";
        }
        return hexdec(preg_replace('/^#/', '', $color));
    }
    if (str_starts_with($color, 'rgba')) {
        throw new ValueError('rgba not supported');
    }
    // Check for rgb or rgba colors
    if (preg_match('/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/D',
        $color, $matches)) {
        return (+$matches[1] << 16) + (+$matches[2] << 8) + (+$matches[3]);
    }
    if (str_starts_with($color, 'hsla')) {
        throw new ValueError('hsla not supported');
    }

    // Check for hsl/hsla colors
    if (preg_match('/^hsl\((\d{1,3}),\s*(\d{1,3})%,\s*(\d{1,3})%\)$/D',
        $color, $matches)) {
        $h = $matches[1] / 360;
        $s = $matches[2] / 100;
        $l = $matches[3] / 100;

        if ($s == 0) {
            $r = $g = $b = $l; // achromatic
        } else {
            $hue2rgb = function ($p, $q, $t) {
                if ($t < 0) $t += 1;
                if ($t > 1) $t -= 1;
                if ($t < 1 / 6) return $p + ($q - $p) * 6 * $t;
                if ($t < 1 / 2) return $q;
                if ($t < 2 / 3) return $p + ($q - $p) * (2 / 3 - $t) * 6;
                return $p;
            };

            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;
            $r = $hue2rgb($p, $q, $h + 1 / 3);
            $g = $hue2rgb($p, $q, $h);
            $b = $hue2rgb($p, $q, $h - 1 / 3);
        }

        return (round($r * 255) << 16) + (round($g * 255) << 8) + round($b * 255);
    }

    // If no valid color format is matched, return false
    return false;
}

/**
 * tests if a value is between 0x000000
 *
 * @param int $colorInt
 * @return int if $colorInt is less than 0 then -1 but if its above 0xFFFFFF then 1, otherwise 0
 */
function Rangetest(int $colorInt): int
{
    if ($colorInt < 0x000000) {
        return -1; // Black
    } elseif ($colorInt > 0xFFFFFF) {
        return +1; // White
    } else return 0;
}

class Color implements JsonSerializable
{
    private int $color; // Stored as 0xRRGGBB

    /**
     * constructs a Color
     *
     * @param string|int|Color $color_value if Color then it basically clones it,
     * if string then cssColorToColorInt 's value, if int then an 0xRR_GG_BB (range 0 to 255)
     * @param int|null $g (range 0 to 255)
     * @param int|null $b (range 0 to 255)
     */
    public function __construct(string|int|self $color_value = 0, ?int $g = null, ?int $b = null)
    {
        if ($color_value instanceof self) {
            $this->color = $color_value->getValue();
        } elseif ($b === null && is_string($color_value)) {
            if (($color = cssColorToColorInt("$color_value")) !== false) {
                $this->color = $color;
            } else {
                throw new InvalidArgumentException("\$color_value($color_value): invalid color");
            }
        } elseif ($g === NULL && $b === null) {
            if (($colortest = Rangetest($this->color = (int)$color_value)) !== 0) {
                throw new InvalidArgumentException("\$color_value($color_value): invalid range ($colortest)");
            }
        } elseif (is_integer($g) && is_int($b)) {
            if (($colortest = Rangetest($this->color = ($color_value << 16) + ($g << 8) + (+$b))) !== 0) {
                throw new InvalidArgumentException("R($color_value), G($g), B($b): invalid range ($colortest)");
            }
        } else {
            throw new InvalidArgumentException('Color __construct');
        }
    }

    /**
     * @return string an hex colorcode
     */
    public function __toString(): string
    {
        return "{$this->toString()}";
    }

    public function toString(toStringColorMode $stringColorMode = toStringColorMode::RGB): string
    {
        if ($this->color === false) {
            return '#000000';
        }
        $color = $this->color;
        if ($color < 0) {
            return '#000000'; // Black
        } elseif ($color > 0xFFFFFF) {
            return '#ffffff'; // White
        }
        return match ($stringColorMode) {
            toStringColorMode::HSL => (function () {
                $HSL = $this->toHSL();
                $h = +"{$HSL['h']}" % 360;
                $s = +"{$HSL['s']}" * 100;
                $l = +"{$HSL['l']}" * 100;
                $h = self::hue_clamp($h);
                return "hsl($h $s $l)/*$this*/";
            })(),
            default => (function () use ($color) {
                return strtolower(sprintf('#%06X', $color));
            }
            )(),
        };
    }

    public function getValue(): false|int|string
    {
        return $this->color;
    }

    public function set_darkness(float $float): Color
    {
        $array = $this->toHSV();
        return Color::fromHSV($array['h'], $array['s'], percent_clamp($float));
    }

    public function toRGB(): array
    {
        return [
            'r' => ($this->color >> 16) & 0xFF,
            'g' => ($this->color >> 8) & 0xFF,
            'b' => $this->color & 0xFF,
        ];
    }

    public function toRGB_0_1(): array
    {
        $rgb = $this->toRGB();
        return [$rgb['r'] / 255, $rgb['g'] / 255, $rgb['b'] / 255];
    }

    public static function fromRGB(int $r, int $g, int $b): self
    {
        return new self(clamp($r, 0, 255), clamp($g, 0, 255), clamp($b, 0, 255));
    }

    private function _internalCalculate_hue($delta, $max, $r, $g, $b): float|int
    {
        if ($delta == 0) {
            $h = 0;
        } elseif ($max === $r) {
            $h = 60 * fmod((($g - $b) / $delta), 6);
        } elseif ($max === $g) {
            $h = 60 * (($b - $r) / $delta + 2);
        } else {
            $h = 60 * (($r - $g) / $delta + 4);
        }
        return self::hue_clamp($h);
    }

    public function toHSL(): array
    {
        [$r, $g, $b] = $this->toRGB_0_1();

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $delta = $max - $min;

        $l = ($max + $min) / 2;
        $s = $delta === 0 ? 0 : $delta / (1 - abs(2 * $l - 1));

        $h = $this->_internalCalculate_hue($delta, $max, $r, $g, $b);

        return ['h' => $h, 's' => $s, 'l' => $l];
    }

    public static function _cxh_toRGB($c, $x, $h): array
    {
        if ($h < 60) {
            [$r, $g, $b] = [$c, $x, 0];
        } elseif ($h < 120) {
            [$r, $g, $b] = [$x, $c, 0];
        } elseif ($h < 180) {
            [$r, $g, $b] = [0, $c, $x];
        } elseif ($h < 240) {
            [$r, $g, $b] = [0, $x, $c];
        } elseif ($h < 300) {
            [$r, $g, $b] = [$x, 0, $c];
        } else {
            [$r, $g, $b] = [$c, 0, $x];
        }
        return [$r, $g, $b];
    }

    public static function _finalizeColor(array $array, $m): Color
    {
        [$r, $g, $b] = $array;
        $r = round(($r + $m) * 255);
        $g = round(($g + $m) * 255);
        $b = round(($b + $m) * 255);

        return new self($r, $g, $b);
    }

    public static function fromHSL(float $h, float $s, float $l): self
    {
        $h = self::hue_clamp($h);
        $s = percent_clamp($s);
        $l = percent_clamp($l);

        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;
        return self::_finalizeColor(self::_cxh_toRGB($c, $x, $h), $m);
        /*[$r, $g, $b] = self::_cxh_toRGB($c, $x, $h);

        $r = round(($r + $m) * 255);
        $g = round(($g + $m) * 255);
        $b = round(($b + $m) * 255);

        return new self($r, $g, $b);*/
    }

    public function toHSV(): array
    {
        [$r, $g, $b] = $this->toRGB_0_1();

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $delta = $max - $min;

        $v = $max;
        $s = $max === 0 ? 0 : $delta / $max;

        $h = $this->_internalCalculate_hue($delta, $max, $r, $g, $b);

        return ['h' => $h, 's' => $s, 'v' => $v];
    }

    /**
     * @param float $h range (0 to 100)
     * @param float $s range (0 to 100)
     * @param float $v range (0 to 100)
     * @return self
     */
    public static function fromHSV(float $h, float $s, float $v): self
    {
        $h = self::hue_clamp($h);
        $s = percent_clamp($s);
        $v = percent_clamp($v);

        $c = $v * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $v - $c;

        return self::_finalizeColor(self::_cxh_toRGB($c, $x, $h), $m);
    }

    public static function create_color(string|int|self|false $color_value, ?Color $DEFAULT = null): ?self
    {
        try {
            return new self($color_value);
        } catch (InvalidArgumentException) {
            return $DEFAULT;
        }
    }

    public static function valid(int|self $hexdigit): bool
    {
        return Rangetest(+"$hexdigit") === 0;
    }

    public function hue_rotate(int $degrees): self
    {
        $array = $this->toHSV();
        $hue = self::hue_clamp($array['h'] + $degrees);
        return Color::fromHSV($hue, $array['s'], $array['v']);
    }

    public function invert(): self
    {
        return new self($this->color ^ 0xffFFff);
    }

    public function overwriteHSL(?float $overwriteHue = null, ?float $overwriteSaturation = null, ?float $overwriteLightness = null): Color
    {
        $array = $this->toHSL();
        return Color::fromHSL(
            $overwriteHue ?? $array['h'],
            $overwriteSaturation ?? $array['s'],
            $overwriteLightness ?? $array['l'],
        );
    }

    public function overwriteHSV(?float $overwriteHue = null, ?float $overwriteSaturation = null, ?float $overwriteValue = null): Color
    {
        $array = $this->toHSV();
        return Color::fromHSV(
            $overwriteHue ?? $array['h'],
            $overwriteSaturation ?? $array['s'],
            $overwriteValue ?? $array['l'],
        );
    }

    public static function hue_clamp(int $degrees): int
    {
        return pythonMod($degrees, 360);
    }

    public function jsonSerialize(): string
    {
        return "$this->color";
    }

    public function debug_data(): array
    {
        $Rangetest = (match (Rangetest($this->color)) {
            -1 => 'too low',
            1 => 'too high',
            default => 'ok',
        });
        return ['RGB' => $this->toRGB(), 'hsv' => $this->toHSV(), 'hsl' => $this->toHSL(),
            'value' => $this->color, 'hexcolor' => "$this", 'Rangetest' => $Rangetest];
    }

    public static function getRandomColor(int $versionId): self
    {
        if ($versionId < 0) {
            throw new InvalidArgumentException("\$versionId ($versionId) is less than zero");
        }
        switch ($versionId) {
            case 1:
                $color = '#';
                for ($i = 0; $i < 6; $i++) {
                    $color = $color . dechex(mt_rand(0, 15));
                }
                return new Color($color);
            case 2:
                return Color::fromHSV(mt_rand(0, 360), 100, 100);
        }
        throw new InvalidArgumentException("\$versionId ($versionId) is not a valid random generator");
    }
}
