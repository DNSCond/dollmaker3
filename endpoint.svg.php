<?php use function HashApi\sha384Base64;

header('cache-control: public, max-age=15, s-max-age=15');
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/HashApi.php";
//$GLOBALS['canonical_redir_path'] = '/dollmaker3/endpoint.svg.php?dna=';
require_once "preprocessor.php";

$nowatermark = str_starts_with($_SERVER['HTTP_REFERER'], 'https://antrequest.nl');
if (!isset($GLOBALS['__FILE__']))
    $GLOBALS['__FILE__'] = null;
if ($GLOBALS['__FILE__'] !== __FILE__)
    header('content-type: image/svg+xml');
require_once 'PathSVG.php';
if ($GLOBALS['__FILE__'] !== __FILE__) echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>";
ob_start(function (string $string): string {
    $return = preg_replace('/\\s+/', " ", $string);
    $return = preg_replace('/\\s*<\\/?svg>\\s*/', " ", $return) . '</svg>';
    $hash = 'sha384b64-' . sha384Base64($return);
    header("hashtag: \"$hash\"");
    return $return;
});

$isTransparent = false;
if (isset($GLOBALS['CharacterTransparent'])) {
    $isTransparent = $GLOBALS['CharacterTransparent'];
}
$isTransparent = !$isTransparent;
$opacity = 0 ? 1 : 0.5;
$stroke = 1;
{
    global $colors;
    $shoes = $colors['shoes'];
    $pants = $colors['pants'];
    $hair = $eyes = $colors['eyes'];
    $skin = $arms = $colors['skin'];
    $bgcolor = $secondary = $colors['body'];
    global $bgcolor, $pants, $shoes, $fgcolor, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
} ?>
<svg width="800" height="1280" viewBox="0 0 800 1280" xmlns="http://www.w3.org/2000/svg">
    <g class="background" stroke-width="0">
        <!--<?php if ($isTransparent) { ?>-->
        <rect width="800" height="1280" fill="#FfFfFf"/>
        <g opacity="0.7">
            <rect width="800" height="1280" fill="<?= "$hair" ?>" class="bgc"/>
            <path d="M 0 384 L 800 576 L 800 1280 L 0 1280 Z" fill="<?= $bgcolor ?>" class="bgc"/>
            <path d="M 0 896 L 800 1000 L 800 1280 L 0 1280 Z" fill="<?= $pants ?>" class="bgc"/>
            <path d="M 600 0 L 400 1280 L 800 1280 L 800 0 Z" fill="<?= $shoes ?>" class="bgc"/>
        </g>
        <!--<?php } ?>-->
    </g>
    <g class="!$nowatermark"><?= !$nowatermark ? '<rect width="440" height="100" fill="#fff100"/>' : '' ?></g>
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
    <g class="PHPX"><?= '<!-- PHPX -->';
        if (!$nowatermark) require_once "{$_SERVER['DOCUMENT_ROOT']}/dollmaker2/watermark.svg.php";
        global $direction;
        foreach ($GLOBALS['assets-'] as $asset) {
            $assetId = str_pad($asset['id'], 4, '0', STR_PAD_LEFT);
            ob_start(fn(string $string): string => str_replace('data-opts=""',
                    "data-asset-id=\"$assetId\" data-asset-options=\"{$asset['opt']}\"", $string));
            $inclusionResult = (bool)include_once __DIR__ . "/assets/anime/$assetId-$direction-.svg.php";
            if (!$inclusionResult) echo "<g data-opts=\"\"/>";
            ob_end_flush();
        }
        echo '<!-- PHPX -->';
        function json_fromArray2(mixed $json, bool|int $JSON_PRETTY_PRINT = true,
                                 bool  $insertToHTML = false): false|string
        {
            $options = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
            if ($insertToHTML) $options |= JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG | JSON_HEX_QUOT;
            if (is_int($JSON_PRETTY_PRINT) && $JSON_PRETTY_PRINT >= 0) {
                $options |= JSON_PRETTY_PRINT;
                $json = json_encode($json, $options);
                return preg_replace_callback('/^ +/m', (function (array $matches)
                use ($JSON_PRETTY_PRINT): string {
                    return str_repeat(' ', (strlen($matches[0]) / 4) * $JSON_PRETTY_PRINT);
                }), $json);
            } elseif (is_bool($JSON_PRETTY_PRINT) && $JSON_PRETTY_PRINT) {
                $options |= JSON_PRETTY_PRINT;
            }
            return json_encode($json, $options);
        } ?></g>
</svg>
