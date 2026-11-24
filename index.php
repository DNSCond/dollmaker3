<?php use function ANTHeader\create_head3;
use function Helpers\Getters\readJSON;

require_once 'AssetHelper.php';
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/helpers.php";
$assetdata = readJSON(__DIR__ . '/assetdata/.assets.json');
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'Pick a Base (Character Customizer)', [
    'stylelinks' => ['statics/styles.css'], 'base' => '/dollmaker3/', 'bread' => [
        array('text' => 'Favicond\'s Character Gallery', 'href' => '/'),
        array('text' => 'Character Customizer', 'href' => '/dollmaker3/'),
    ],
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
echo "</div><div class=divs><h2 class='store-header preset-h2'>Presets</h2>" . (function () {
        $size = "width=800 height=1280";
        $array = array(
            'Sun' => 'v1u._1WU_f9VvP3_ZZW9_1W8_f80JNH_JSgs_wDx_QQD0AcA0QcA1AcA',
            'Moon' => 'v1u._3AZGf_tzan_0eD9__j9jP_9wIX_6cyF_wDx_QQD0AcA0QcA0wcA',
            'V3id' => 'v1u._wAspP_9_f3_ueH8_wCkAP-kcQD_vYnk_wDx_QQC0AcB0QcB',
            'Fire' => 'v1u._1WU_f9VlP3_ZZW9_1W8_f80JNH_JSgs_wAAgAQDAQABAgABBwAB',
            'randInt' => 'v1u._5HYqP-lBSX_1UlZ_wgZGf_0EQz__Vhx_1QtzQQFAQAABAAABQAABwAA1AcA',
            'some?' => 'v1u.__QtRf8ZkQz_ueH8_8T96f99uMX_nZGU_-jcUQQD0AcA0QcA0gcA',
            'Kine' => 'v2u._4llUf-gBcj_ueH8_wlZ4P_dcGD_fE1R_0glff8JWeD_fE1R_wAAAAQAAgkAAIoTAA',
            'bright' => 'v1u.__zpcf9cJEH_ueH8_yj44f_Qyf3_DNXw_1z1MAQE0AcA0gcA0wcA1AcA',
            'dark' => 'v1u._7k1nf9JRLX_ueH8_1ksif_UzBz_5HwU_7hdZAQD0AcA0gcA0wcA',
            'v1/2' => 'v2u._x28Ff_9_f3_ueH8_2QMdP_Y6K3_0DFt_2gVNP9kDHT_aBU0_wAAAAQAAwYAANAHAN8HAA',
            'transistor' => 'v1u._8WZ-P-wDFj_ueH8_2CtWf_4tAX_9IWM_yh1eAQCAQAAAwAA',
            'Red Moon' => 'v1u._zwcmf_9_f3_ueH8_zEVff8lEGX_GQxA_wDx_QQD0AcA0gcA0wcA',
            'ball' => 'v1u._wR9Zf_9_f3_ueH8_6Ro6P9QcLT_iWTE_wDx_QQFBQAABgAABwAA0AcA4AcA',
            'prototype' => 'v1u.__3RWf8AAAD_ueH8__1Z_f9ZjP3_QHQZ__0MAAQCuAsAuQsA',
            'New Ciolor' => 'v1u._-R9GP8NDJn_ueH8_8CxAf8F3JT_iSyU_3ip7AQCugsAuwsA',
            'brown' => 'v2u._628_P_98K3_JDVZ_wBF_f-kcQD_xa39_wDx_f-t5f3_xa39_wAAAAQAAggAAIkTAA',
            'Lime' => 'v2u._yyVWf8ApAD_ueH8_13xhP_8Can_hCAh_wDx_f9d8YT_hCAh_wAAAAQAArwLAIoTAA',
            'Red' => 'v1u._1xtHP9sVR3_ueH8_xkQ5P_s2Uz_uWWg_wDx_QQCugsAvAsA',
            'Peasant' => 'v2u._wR9Zf8EfWX_ueH8_6Ro6P9QcLT_iWTE_wDx_f-kaOj_iWTE_wAAAAQAAggAAIsTAA',
            'cruft' => 'v2u._3VN1f8szeD_ueH8__GYTP_obVT_MDm9_zgYzP_xmEz_PDw8_wAAAAQAAgkAAIwTAA',
        ); // f4e0f0; 78bdf8
        $output = array();
        foreach ($array as $name => $href) $output[] = "<div class=store-div><div" .
            " CLASS=padding><a href=$href>$name</a></div><a href=$href><img src" .
            "=img/$href alt=\"clothing option &quot;$name&quot;\" loading=lazy" .
            " class=store-img $size></a></div>";
        return "\n" . implode("", $output);
    })() . "</div>";
