<?php use function ANTHeader\create_head3;
use function Helpers\Getters\readJSON;

require_once 'AssetHelper.php';
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/helpers.php";
$assetdata = readJSON(__DIR__ . '/assetdata/.assets.json');
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'Pick a Base (Character Customizer)', [
    'stylelinks' => ['statics/styles.css'], 'base' => '/dollmaker3/',
]);
$assetHelper = new AssetHelper('__GoAP_4_Yz_ueH8_31YAP9lRAD_QC0A_wDx_QQA', 1)->canonicalize();
echo "<div class=divs><h1 class=index>$title</h1>";
foreach ($assetdata['bodynames'] as $item) {
    $innerHelper = new AssetHelper($assetHelper[1], 2);
    if ($item === 'new-phase') {
        foreach ([3003, 5003, 5005] as $assetId) $innerHelper->addAsset($assetId, 0);
    } elseif ($item === 'legacy-one') {
        foreach ([6, 2000, 2015] as $assetId) $innerHelper->addAsset($assetId, 0);
    } elseif ($item === 'door') {
        $innerHelper->addAsset(200, 0);
    } elseif ($item === 'rocket') {
        $innerHelper->addAsset(201, 0);
    } elseif ($item === 'favicond') {
        $innerHelper->addAsset(202, 0);
    }
    $innerHelper = $innerHelper->canonicalize();
    $href = "$innerHelper[0]$innerHelper[1]";
    $hrel = "_$item/";
    echo "<div class=store-div><div CLASS=padding><a href=$hrel$href>$item</a>" .
        "</div><a href=$hrel$href><img src=img/$href alt = 'Body Option &quot;" .
        "$item&quot;' loading=lazy class=store-img width=800 height=1280></a>";
    echo "</div>";
}
echo "</div>";
