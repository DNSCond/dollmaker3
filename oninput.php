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

    $afterColors = (7 * 4); // 28 bytes

    // 1. Gather and sanitize incoming assets from POST
    $validAssets = [];
    $max = 50;
    $count = 0;
    if (array_key_exists('assets', $_POST) && is_array($_POST['assets'])) {
        foreach ($_POST['assets'] as $assetId) {
            // Ensure it's a valid number fitting within uint16 (0 - 65535)
            if (is_numeric($assetId)) {
                $id = (int)$assetId;
                if ($id >= 0 && $id <= 65535) {
                    $validAssets[] = $id;
                    if (++$count > $max) break;
                }
            }
        }
    }

    // 2. Calculate exact buffer size dynamically
    // 28 bytes (colors) + 1 byte (flags) + 1 byte (asset count) + (3 bytes per asset)
    $totalBytes = $afterColors + 2 + (count($validAssets) * 3);
    $result = new BinaryView($totalBytes);

    // 3. Write Colors (Bytes 0 to 27)
    foreach ($keys as $index => $_colorKey) {
        RGBToRGBA32($result, (int)hexdec($matches[$index + 1]), $index * 4);
    }

    // 4. Calculate Global Options Byte
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

    // Write the Global Options Byte at index 28
    $result->setUint8($afterColors, $b111);
    $result->setUint8(++$afterColors, count($validAssets));

    // 5. Pack the Assets sequentially right after the flag byte
    $currentOffset = $afterColors + 1;
    foreach ($validAssets as $assetId) {
        // Write the 2-byte Asset ID (uint16) at current offset
        $result->setUint16($currentOffset, $assetId);

        // Write the 1-byte Asset Option (uint8) right after the ID (+2 bytes)
        $result->setUint8($currentOffset + 2, 0); // Currently hardcoded to 0

        // Move pointer forward by exactly 3 bytes for the next block
        $currentOffset += 3;
    }

    http_response_code(303);
    header("dataview-length:{$result->getLength()}");
    header("Location: /dollmaker3/v1u.{$result->toBase64URL()}");
    exit;
}

http_response_code(303);
header("Location: /dollmaker3/");
