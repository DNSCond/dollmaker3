<?php use DataViewed\BinaryView;
use function DataViewed\RGBToRGBA32;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/createHead2.php";
require_once "BinaryHelper.php";
require_once "getColor.php";
global $colors;
$keys = array_keys($colors);
if (preg_match('/^' . (str_repeat('#?([a-f-A-F0-9]{6});', 7)) . '$/D',
    implode(';', array_map(fn($color) => is_string($_POST[$color]) ? $_POST[$color] : 'Invalid-',
        $keys)) . ';', $matches)) {
    //$result = new BinaryView((count($keys) * 4) + 1 + 1);
    // Sets the buffer size to exactly 29 bytes (28 bytes for colors + 1 byte for flags)
    $result = new BinaryView((count($keys) * 4) + 1);
    foreach ($keys as $index => $_colorKey) {
        RGBToRGBA32($result, (int)hexdec($matches[$index + 1]), $index * 4);
    }
    $b111 = 0b100;
    if (array_key_exists('direction', $_POST)) {
        if (preg_match('/^(Front|Back)-(Left|Right)$/D', "{$_POST['direction']}", $matched)) {
            $b111 = ($matched[1] === 'Back' ? 0b001 : 0) | ($matched[2] === 'Left' ? 0b010 : 0);
        } else $b111 = match ("{$_POST['direction']}") {
            'Right' => 0b101,
            'Front' => 0b100,
            'Back' => 0b111,
            'Left' => 0b110,
            default => 0,
        };
    }
    if (array_key_exists('opaque', $_POST)) {
        header('dev-result: ' . decbin(+(bool)$_POST['opaque'] << 3));
        $b111 |= +(bool)$_POST['opaque'] << 3;
    }
    $result->setUint8(count($keys) * 4, $b111);
    http_response_code(303);
    header("dataview-length:{$result->getLength()}");
    header("Location: /dollmaker3/v1u.{$result->toBase64URL()}");
    exit;
}

http_response_code(303);
header("Location: /dollmaker3/");
