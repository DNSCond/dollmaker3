<?php use DataViewed\BinaryView;
use function DataViewed\RGBToRGBA32;

require_once "BinaryHelper.php";

$TChar = false;
$direction = 'f-';
$assets = array();
$fullDirection = '';
$dirByte = 0b100;
$opaque = false;
if (preg_match('/^v(\\d+)\\.?(u)\\.([A-Za-z0-9\\-_]+)$/D', $_GET['dna'], $matches)) {
    if (+$matches[1] !== 1) {
        http_response_code(400);
        exit('<!DOCTYPE><pre>That versions doenst exist (<a href=/dollmaker3/>Home</a>)');
    }
    $dataView = BinaryView::fromBase64URL($matches[3]);
    $offset = 7 * 4;
    // F is Front, R is Right, L is Left, B is Back
    $dirByte = $dataView->getUint8($offset);
    $frontBack = (bool)($dirByte & (1 << 0));
    $leftRight = (bool)($dirByte & (1 << 1));
    $deg45 = (bool)($dirByte & (1 << 2));
    $opaque = (bool)($dirByte & (1 << 3));
    $direction = ($frontBack ? 'b' : 'f') . ($leftRight ? 'l' : 'r');
    if ($deg45) {
        $direction = match ($direction) {
            'bl' => 'b-',
            'br' => '-r',
            'fl' => '-l',
            'fr' => 'f-',
        };
    }
    $y = match ($direction[0]) {
        'f' => 'Front',
        'b' => 'Back',
        default => '-',
    };
    $x = match ($direction[1]) {
        'r' => 'Right',
        'l' => 'Left',
        default => '-',
    };
    $maxAssetCount = 50;
    if ($TChar) header('TChar-Direction: ' . ($fullDirection = trim("$y-$x", '-')));
    $assetCount = $dataView->getUint8(++$offset);
    $assetCount = $assetCount === false ? 0 : $assetCount;
    $assetCount = $clamped = max(min($assetCount, $maxAssetCount), 0);
    for ($i = 0; $i < $clamped; $i++) {
        $index = $i * 3;
        $assetId = $dataView->getUint16($offset + $index);
        $assetOpt = $dataView->getUint8($offset + $index + 2);
        if ($TChar) header("TChar-asset-Addition: assetid=$assetId, option=$assetOpt", false);
        $assets[] = array('id' => $assetId, 'opt' => $assetOpt);
    }
} else {
    header('x-error: no dataview found');
    $dataView = null;
    $assetCount = 0;
}
usort($assets, fn($le, $ri) => $le['id'] - $ri['id']);
if ($TChar) header("TChar-asset-Count: assetCount=$assetCount, actual=" . count($assets));
require_once 'getColor.php';
global $colors;
$canonicalColorIndex = 0;
$canonicalized = new BinaryView((7 * 4) + 1 + 1 + ($assetCount * 3));
foreach ($colors as $color => $value) {
    if (preg_match('/^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/D', strtolower("$value"), $matches)) {
        $r = hexdec($matches[1]) & -3;
        $g = hexdec($matches[2]) & -3;
        $b = hexdec($matches[3]) & -3;
        RGBToRGBA32($canonicalized, $r << 16 | $g << 8 | $b, $canonicalColorIndex++ * 4);
    }
    if ($TChar) header("TChar-Color-$color:$value");
}
$i = 0;
$canonicalColorIndex *= 4;
$canonicalized->setUint8($canonicalColorIndex++, ($dirByte & 0b111) | ($opaque << 3));
$canonicalized->setUint8($canonicalColorIndex++, $assetCount);
foreach ($assets as $asset) {
    $index = $canonicalColorIndex + ($i++ * 3);
    ['id' => $assetId, 'opt' => $assetOpt] = $asset;
    $canonicalized->setUint16($index, $assetId);
    $canonicalized->setUint8($index + 2, $assetOpt);
}

$GLOBALS['assets-'] = $assets;
$original = $dataView?->toBase64URL();
$GLOBALS['isCanonical'] = ($cDNA = $canonicalized->toBase64URL()) === $original;
header("T-Canonical-DNAString: $cDNA; isCanonical=?" . (int)($GLOBALS['isCanonical']));
$GLOBALS['canonicalFullString'] = "v1u." . ($GLOBALS['canonicalB64'] = $cDNA);

$origBytes = $dataView?->asArray();
$canonBytes = $canonicalized->asArray();
if (!$GLOBALS['isCanonical'] && is_string($GLOBALS['canonical_redir_path']) && $original) {
    http_response_code(307);
    header("Location: {$GLOBALS['canonical_redir_path']}{$GLOBALS['canonicalFullString']}");
}
