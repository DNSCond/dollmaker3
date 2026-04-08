<?php require_once './toRasterImage.php';
ob_start();
$endpoint = 'endpoint.svg.php';
$GLOBALS['CharacterTransparent'] = array_key_exists('transparent', $_GET)
    || array_key_exists('trans', $_GET);
require_once "$endpoint";
toRasterImage(ob_get_clean(), 'image/png');
