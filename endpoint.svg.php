<?php use function HashApi\sha384Base64;

//header('cache-control: public, max-age=15, s-max-age=15');
header('cache-control: private, max-age=0');
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/HashApi.php";
$GLOBALS['canonical_redir_path'] = '/dollmaker3/endpoint.svg.php?dna=';
$GLOBALS['isFor'] = 'svgDisplay';
require_once "preprocessor.php";

$nowatermark = str_starts_with($_SERVER['HTTP_REFERER'], 'https://antrequest.nl');
if (!isset($GLOBALS['__FILE__']))
    $GLOBALS['__FILE__'] = null;
if ($GLOBALS['__FILE__'] !== __FILE__)
    header('content-type: image/svg+xml');
require_once 'PathSVG.php';
if ($GLOBALS['__FILE__'] !== __FILE__) echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>";
ob_start(function (string $string): string {
    //$string = preg_replace('/\\s+/', " ", $string);
    $string = preg_replace('/\\s*<\\/?svg>\\s*/', " ", $string) . '</svg>';
    $hash = 'sha384b64-' . sha384Base64($string);
    header("hashtag: \"$hash\"");
    return $string;
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
{
    global $colors;
    $shoes = $colors['shoes'];
    $pants = $colors['pants'];
    $bgcolor = $colors['body'];
    $lights = $colors['lights'];
    $hair = $eyes = $colors['eyes'];
    $skin = $arms = $colors['skin'];
    $secondary = $colors['secondary'];
    global $bgcolor, $pants, $shoes, $fgcolor, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
} global $opaque ?>
<svg width="800" height="1280" viewBox="0 0 800 1280" xmlns="http://www.w3.org/2000/svg">
    <g class="background" stroke-width="0" visibility='visible'>
        <!--<?php if ($isTransparent) { ?>-->
        <rect width="800" height="1280" fill="#FfFfFf"/>
        <g opacity="<?= $opaque ? '1' : '0.7' ?>">
            <rect width="800" height="1280" fill="<?= "$hair" ?>" class="bgc"/>
            <path d="M 0 384 L 800 576 L 800 1280 L 0 1280 Z" fill="<?= $bgcolor ?>" class="bgc"/>
            <path d="M 0 896 L 800 1000 L 800 1280 L 0 1280 Z" fill="<?= $pants ?>" class="bgc"/>
            <path d="M 600 0 L 400 1280 L 800 1280 L 800 0 Z" fill="<?= $shoes ?>" class="bgc"/>
        </g>
        <!--<?php } ?>-->
    </g>
    <g class="!$nowatermark"
       visibility='visible'><?= !$nowatermark ? '<rect width="440" height="100" fill="#fff100"/>' : '' ?></g>
    <g fill="#ae782f"><?= (function () {
            $width = 20;
            $RightX = 800 - $width;
            $DownY = 1280 - $width;
            return "\n" . <<<SVG
            <rect x="0" y="0" width="$width" height="1280" class="wall left"/>
            <rect x="$RightX" y="0" width="$width" height="1280" class="wall right"/>
            <rect x="0" y="0" width="800" height="$width" class="wall up"/>
            <rect x="0" y="$DownY" width="800" height="$width" class="wall down"/>
            SVG;
        })() . "\n" ?></g>
    <g class="PHPX" visibility='visible'><?= '<!-- PHPX -->';
        global $direction;
        $normal = array();
        $fronts = array();
        $json = file_get_contents('store/assets.json');
        if ($json) $json = json_decode($json, true);
        else $json = null;
        if (!$nowatermark) require_once "{$_SERVER['DOCUMENT_ROOT']}/dollmaker3/watermark.svg.php";
        function createAsset(array $asset, string $type): void
        {
            global $direction;
            $svgType = $type === '' ? 'Middle' : $type;
            $opacity = ($asset['opt'] & (1 << 1)) !== 0 ? '0.8' : 1;
            //$opacity=($asset['opt'] & (1 << 1)) !== 0 ?'0.55' : 1;
            $assetId = str_pad($asset['id'], 4, '0', STR_PAD_LEFT);
            ob_start(fn(string $string): string => "<g opacity='$opacity' data-id=\"{$asset['id']}\" data-type=\"$svgType\">$string</g>");
            if (file_exists(__DIR__ . "/store/assets/$assetId-$direction-$type.svg.php"))
                ($inclusionResult = (bool)include_once __DIR__ . "/store/assets/$assetId-$direction-$type.svg.php");
            else $inclusionResult = false;
            if (!$inclusionResult) {
                echo "<g data-opts=\"inclusion-failed\" data-id=\"{$asset['id']}\" data-type=\"$svgType\"/>";
            }
            ob_end_flush();
        }

        $assetsEquipped = array_map(fn($asset) => +$asset['id'], $GLOBALS['assets-']);
        function hasEquipped(int $id): bool
        {
            global $assetsEquipped;
            return in_array($id, $assetsEquipped);
        }

        foreach ($GLOBALS['assets-'] as $asset) {
            $ZindexLayer = array('');
            $assetId = str_pad($asset['id'], 4, '0', STR_PAD_LEFT);
            $jsonArray = $json["assets"]["$assetId-$direction-.svg"] ?? array();
            if (array_key_exists('ZindexLayer', $jsonArray)) {
                $ZindexLayer = $jsonArray['ZindexLayer'];
                if (count($ZindexLayer) == 0) {
                    $ZindexLayer = array('');
                }
            }
            if (in_array('Back', $ZindexLayer))
                createAsset($asset, 'Back');
            if (in_array('', $ZindexLayer)) {
                $assetId = str_pad($asset['id'], 4, '0', STR_PAD_LEFT);
                if (file_exists(__DIR__ . "/store/assets/$assetId-$direction-.svg.php")) {
                    $normal[] = $asset;
                }
            }
            if (in_array('Front', $ZindexLayer)) {
                $assetId = str_pad($asset['id'], 4, '0', STR_PAD_LEFT);
                if (file_exists(__DIR__ . "/store/assets/$assetId-$direction-Front.svg.php")) {
                    $fronts[] = $asset;
                }
            }
        }
        foreach ($normal as $asset) createAsset($asset, '');
        foreach ($fronts as $asset) createAsset($asset, 'Front');
        echo '<!-- PHPX -->' ?></g>
</svg>
