<?php use function Helpers\Getters\readJSON;

$dnastring = null;
$assetHelper = null;
require_once "AssetHelper.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/helpers.php";

require_once "BinaryHelper.php";
$assetdata = $GLOBALS['assetdata'] = readJSON(__DIR__ . '/assetdata/.assets.json');
if (array_key_exists('dna', $_GET) && preg_match('/^v(\\d+)\\.?(u)\\.([A-Za-z0-9\\-_]+)$/D',
        $_GET['dna'], $matches)) {
    try {
        $assetHelper = new AssetHelper($matches[3], $matches[1]);
        $dnastring = $_GET['dna'];
    } catch (InvalidArgumentException) {
    }
}
if (is_null($assetHelper)) {
    $assetHelper = new AssetHelper('__GoAP_4_Yz_ueH8_31YAP9lRAD_QC0A_wDx_QQA', 1);
}

if (array_key_exists('pfpmode', $_GET))
    $assetHelper->setPFPMode((bool)$_GET['pfpmode']);
[$v, $canonicalized_dnastring] = $assetHelper->canonicalize();
$canonicalized = new AssetHelper($canonicalized_dnastring, 2);
if (array_key_exists('canonical_redir_path', $GLOBALS)) {
    if ("$v$canonicalized_dnastring" !== "$dnastring") {
        http_response_code(307);
        header("Location: {$GLOBALS['canonical_redir_path']}$v$canonicalized_dnastring");
        exit;
    }
}

$fullDirection = '';
$GLOBALS['canonicalized_serializedB64U'] = "$canonicalized_dnastring";
$GLOBALS['canonicalized_serialized'] = "$v$canonicalized_dnastring";
$directionName = $canonicalized->getDirectionName();
$GLOBALS['assets-'] = $canonicalized->getAssets();
$colors = $canonicalized->getComputedColors();
$direction = $canonicalized->getDirection();
$pfpMode = $canonicalized->getPFPMode();
//$assetHelper->getAssociativeAssets();
$opaque = $canonicalized->getOpaque();

//if (array_key_exists('isFor', $GLOBALS)) {
//if ($isLocked && $GLOBALS['isFor'] === 'svgDisplay') foreach ($colors as $color => $value)
//if (preg_match('/^#([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/D', strtolower("$value"), $matches)) {
//$r = hexdec($matches[1]);$g = hexdec($matches[2]);$b = hexdec($matches[3]);
//$gray = (int)round(0.299 * $r + 0.587 * $g + 0.114 * $b);
//$r = $g = $b = $gray;$r = $r & -3;$g = $g & -3;$b = $b & -3;
//$colors[$color]=colorIntToString($r << 16 | $g << 8 | $b);}}
