<?php use DataViewed\BinaryView;
use function DataViewed\RGBToRGBA32;
use Random\RandomException;

header('cache-control:no-store, no-cache');
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/createHead2.php";

require_once "BinaryHelper.php";

function generateRandomColor(): string
{
    $color = '';
    for ($i = 0; $i < 6; $i++) {
        $color = $color . dechex(mt_rand(0, 15));
    }
    return $color;
}

try {
    $assets = random_int(2, 4);
} catch (RandomException $e) {
    $assets = 2;
}

$filegc = file_get_contents(__DIR__ . '/store/assets-random.json');
if ($filegc) $json = json_decode($filegc, true); else {
    $json = null;
    $assets = 0;
}

$afterColors = (7 * 4); // 28 bytes
$totalBytes = $afterColors + 2 + (($assets) * 3);
$result = new BinaryView($totalBytes);
for ($i = 0; $i < 7; $i++) {
    $color = generateRandomColor();
    if ($i === 2) $color = '#fce1b9';
    RGBToRGBA32($result, (int)hexdec($color), $i * 4);
}
$result->setUint8($afterColors++, 0b100);
$result->setUint8($afterColors++, $assets);
$offset = 0;
/*if ($json) {
    ['key' => $baseBody, 'val' => $bodilyAssets] = pickRandomFromArray($json);
    $result->setUint16($afterColors + $offset, (int)$baseBody);
    $result->setUint8($afterColors + $offset + 2, 0);
    $offset += 3;
    for ($j = 0; $j < $assets - 1; $j++) {
        ['key' => $key, 'val' => $value] = pickRandomFromArray($bodilyAssets);
        unset($bodilyAssets[$key]);
        $result->setUint16($afterColors + $offset, (int)$value);
        $result->setUint8($afterColors + $offset + 2, 0);
        $offset += 3;
    }}*/
if ($json) {
    ['key' => $baseBody, 'val' => $bodilyAssets] = pickRandomFromArray($json);
    $result->setUint16($afterColors + $offset, (int)$baseBody);
    $result->setUint8($afterColors + $offset + 2, 0);
    $offset += 3;

    // Shuffle the assets once so they are in random order
    shuffle($bodilyAssets);

    for ($j = 0; $j < $assets - 1; $j++) {
        // Safety check: break if we run out of unique assets in the JSON array
        if (empty($bodilyAssets)) {
            break;
        }

        // Pop the last asset off the array (guarantees no duplicates and removes it)
        $value = array_pop($bodilyAssets);
        $result->setUint16($afterColors + $offset, (int)$value);
        $result->setUint8($afterColors + $offset + 2, 0);
        $offset += 3;
    }
}
header("assets: $assets");

header("{$_SERVER['SERVER_PROTOCOL']} 307 Temporary Redirect");
header("Location:/dollmaker3/v1u.{$result->toBase64URL()}");
function pickRandomFromArray($array): array
{
    //$keys = array_keys($array);return $array[$keys[rand(0, count($keys))]];
    $key = array_rand($array);
    return ['key' => $key, 'val' => $array[$key]];
}
