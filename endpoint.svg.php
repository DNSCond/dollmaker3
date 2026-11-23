<?php use function Helpers\Getters\getThingOrNull;

$GLOBALS['canonical_redir_path'] = '/dollmaker3/endpoint.svg.php?dna=';
$GLOBALS['isFor'] = 'svgDisplay';
require_once 'PathSVG.php';
$inherited = array_key_exists('inherited', $GLOBALS) && $GLOBALS['inherited'];
if (!$inherited) {
    header('content-type: image/svg+xml');
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    require_once "preprocessor.php";
}
ob_start(function (string $string): string {
    $string = preg_replace('/\\s+/', " ", $string);
    return "$string";
});

function mkshadow(string $shadow, int $shadowpercent): string
{
    $shadow = str_replace(['#', '0x'], '', $shadow);
    $hex = hexdec($shadow);
    $r = ($hex >> 16) & 0xFF;
    $g = ($hex >> 8) & 0xFF;
    $b = ($hex) & 0xFF;
    $factor = $shadowpercent / 100;
    $r = max(0, floor($r * $factor));
    $g = max(0, floor($g * $factor));
    $b = max(0, floor($b * $factor));
    // '%06x' forces the string to be padded with leading zeros up to 6 characters
    return '#' . sprintf('%06x', ($r << 16) | ($g << 8) | $b);
}

$isTransparent = false;
if (isset($GLOBALS['CharacterTransparent'])) {
    $isTransparent = $GLOBALS['CharacterTransparent'];
}
$isTransparent = !$isTransparent;
$opacity = 1;
$stroke = 1;
//$colors = completeColorArray($colors);
global $colors, $opaque;
$devMode = false;
global $direction;
$normal = array();
$fronts = array();
$back_s = array();
foreach ($GLOBALS['assets-'] as $asset) {
    $assetId = str_pad($asset['id'], 4, '0', STR_PAD_LEFT);
    $assetObj = getThingOrNull($GLOBALS['assetdata'], ['d', $assetId, $direction]);
    if (array_key_exists('Front', $assetObj)) $fronts[] = ['asset' => $asset, 'name' => $assetObj['Front']];
    if (array_key_exists('Back', $assetObj)) $back_s[] = ['asset' => $asset, 'name' => $assetObj['Back']];
    if (array_key_exists('fn', $assetObj)) $normal[] = ['asset' => $asset, 'name' => $assetObj['fn']];
    $devMode = $devMode || getThingOrNull($assetObj, ['data', 'dev-mode']);
}
if ($devMode) {
    header('cache-control: public, max-age=0');
} else {
    header('cache-control: public, max-age=15, s-maxage=15');
}
$strokeWidth = (!(array_key_exists('no-stroke', $_GET) && $_GET['no-stroke'])) * 8;
$yoffset = 0;
global $pfpMode;
if ($pfpMode) {
    $w = 512;
    $h = 512;
    $xoffset = 140;
    $isTransparent = false;
} else {
    $w = 800;
    $h = 1280;
    $xoffset = 0;
} ?>
<svg width="<?= $w ?>" height="<?= $h ?>"
     viewBox="<?= "$xoffset $yoffset $w $h" ?>"
     xmlns="http://www.w3.org/2000/svg" id='main-svg'>
    <g class="background outer"><?= '<!-- PHPY -->';
        ob_start(fn(string $string): string => str_replace(
                "\x3cg", "\x3cg class='background inner'",
                str_replace('svg', 'g', $string)));
        if ($isTransparent) require_once __DIR__ . '/Bg.php';
        ob_end_flush();
        echo "</g><g stroke-linecap='round' stroke-width='$strokeWidth' stroke='#000000' stroke-linejoin='round'>";
        function createAsset(array $asset, string $type): void
        {
            $dname = $asset['name'];
            $asset = $asset['asset'];
            $GLOBALS['opts'] = $asset['opt'];
            $svgType = $type === '' ? 'Middle' : $type;
            $assetId = str_pad($asset['id'], 4, '0', STR_PAD_LEFT);
            ob_start(function (string $string) use ($svgType, $asset): string {
                $string = rtrim($string);
                if (str_starts_with($string, '<!-- Dev Mode Enabled -->'))
                    $string = substr($string, 25);
                if (str_starts_with($string, '<svg>') &&
                        str_ends_with($string, '</svg>')) {
                    $substr = substr($string, 5, -6);
                    return "<g data-id='{$asset['id']}'>$substr</g>";
                }
                //$b64 = base64_encode($string);
                return "<g data-id='{$asset['id']}' data-failed-to-load='\'/>";
            });
            (include __DIR__ . "/assetdata/$dname");
            ob_end_flush();
        }

        function hasOption(int $opt): bool
        {
            return ($GLOBALS['opts'] & (1 << ($opt - 1)));
        }

        // required in assets
        $assetsEquipped = array_map(fn($asset) => +$asset['id'], $GLOBALS['assets-']);
        function hasEquipped(int $id): bool
        {
            global $assetsEquipped;
            return in_array($id, $assetsEquipped);
        }

        function multiplyString(float $with, string $string): string
        {
            return preg_replace_callback('/\\d+/', fn(array $matches) => (+$matches[0]) * $with, $string);
        }

        global $xoffset;
        $Favicar_offsetY = 0;
        $Favicar_multiplySize = 16;
        $Favicar_offsetX = $xoffset;
        foreach ($back_s as $asset) createAsset($asset, 'Back');
        foreach ($normal as $asset) createAsset($asset, '');
        foreach ($fronts as $asset) createAsset($asset, 'Front') ?></g>
</svg>
