<?php use function Helpers\Getters\readJSON;

require_once "AssetHelper.php";
$assetHelper = null;
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/helpers.php";

require_once "BinaryHelper.php";
$assetdata = $GLOBALS['assetdata'] = readJSON(__DIR__ . '/assetdata/.assets.json');
if (array_key_exists('dna', $_GET) && preg_match('/^v(\\d+)\\.?(u)\\.([A-Za-z0-9\\-_]+)$/D',
        $_GET['dna'], $matches)) {
    try {
        $assetHelper = new AssetHelper($matches[3], $matches[1]);
    } catch (InvalidArgumentException) {
    }
}
if (is_null($assetHelper)) {
    $assetHelper = new AssetHelper('__GoAP_4_Yz_ueH8_31YAP9lRAD_QC0A_wDx_QQA', 1);
}

$serialized = "$assetHelper";
$canonicalized = $assetHelper->canonicalize();
$canonicalized_serialized = "$canonicalized";
if (array_key_exists('canonical_redir_path', $GLOBALS)) {
    if ("$serialized" !== "$canonicalized_serialized") {
        http_response_code(307);
        header("Location: {$GLOBALS['canonical_redir_path']}$canonicalized_serialized");
        exit;
    }
}

$fullDirection = '';
$direction = $canonicalized->getDirection();
$GLOBALS['assets-'] = $canonicalized->getAssets();
$colors = $canonicalized->getColors();
$pfpMode = $canonicalized->pfpMode;
$opaque = $canonicalized->opaque;
