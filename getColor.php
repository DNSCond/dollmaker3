<?php global $dataView;

use function DataViewed\RGBA32ToRGB;

function normalizeColor(string|int $color): ?int
{
    if (is_string($color) || (is_int($color) && $color >= 0 && $color <= 0xffFFff)) {
        if (is_string($color)) {
            if (preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/D',
                strtolower("$color"), $matches)) {
                $r = hexdec($matches[1]);
                $g = hexdec($matches[2]);
                $b = hexdec($matches[3]);
            } else return null;
        } else if (is_int($color)) {
            $r = ($color >> 16) & 0xFF;
            $g = ($color >> 8) & 0xFF;
            $b = $color & 0xFF;
        } else return null;
        $r = $r & -3;
        $g = $g & -3;
        $b = $b & -3;
        return $r << 16 | $g << 8 | $b;
    }
    return null;
}

function colorIntToString(?int $color): ?string
{
    if (is_null($color)) return null;
    return '#' . str_pad(dechex($color), 6, '0', STR_PAD_LEFT);
}

$colors = $default_colors = [
    'body' => '#00a8f3',
    'secondary' => '#8cfffa',
    'skin' => '#fee1b9',
    'eyes' => '#00587f',
    'pants' => '#004665',
    'shoes' => '#002d40',
    'lights' => '#fff100',
];
$colorList = ['body', 'secondary', 'skin', 'eyes', 'pants',
    'shoes', 'lights', 'hair', 'bottom', 'placeholder'];
$colorDisplayList = ['body', 'secondary', 'skin', 'eyes', 'hair',
    'pants', 'shoes', 'bottom', 'lights', 'placeholder'];
$colorsFull = completeColorArray($colors);
function completeColorArray(array $array): array
{
    global $default_colors;
    if (!array_key_exists('hair', $array))
        $array['hair'] = getThisOrThat($array, 'eyes', $default_colors['eyes']);
    if (!array_key_exists('bottom', $array)) $array['bottom'] = '#001620';
    if (!array_key_exists('placeholder', $array)) $array['placeholder'] = '#000000';
    return $array;
}

function getThisOrThat(array $array, string|int $key, mixed $default, bool $mustNotBeNull = false): mixed
{
    if (array_key_exists($key, $array)) {
        $mixed = $array[$key];
        if ($mustNotBeNull && is_null($mixed)) return $default;
        return $mixed;
    }
    return $default;
}
