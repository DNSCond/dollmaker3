<?php use JSONWT\JWT;
use DataViewed\BinaryView;
use function HashApi\sha384Base64;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/JSONWT.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/HashApi.php";
require_once "BinaryHelper.php";

// must match the one in /gallery/
const secret = '026c56c425825f58b24b96f3ea54dfa46b563a4139687039e837e2824868c75bc5fb6ca2e07e41be46b830faeedb0c99a6c42ed12d6e14a39748bdf55802e827ca5526';

/**
 * @param string $token
 * @return false|array
 */
function validateToken(string $token): false|array
{

    return new JWT(secret)->validate($token);
}

$nowatermark = str_starts_with($_SERVER['HTTP_REFERER'], 'https://antrequest.nl');
if (array_key_exists('token', $_GET))
    if ($token = validateToken($_GET['token']))
        if ($token['nowatermark']) $nowatermark = true;
if ($GLOBALS['__FILE__'] !== __FILE__)
    header('content-type: image/svg+xml');
require_once 'PathSVG.php';
if ($GLOBALS['__FILE__'] !== __FILE__) echo "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>";
ob_start(function (string $string): string {
    $return = preg_replace('/\\s+/', " ", $string);
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
$fullDirection = '';
{
    $direction = 'fr';
    if (preg_match('/^v(\\d+)(u)\\.([A-Za-z0-9\\-_]+)$/D', $_GET['dna'], $matches)) {
        $dataView = BinaryView::fromBase64URL($matches[3]);
        $offset = 7 * 4;
        // F is Front, R is Right, L is Left, B is Back
        $dirByte = $dataView->getUint8($offset);
        $frontBack = (bool)($dirByte & (1 << 0));
        $leftRight = (bool)($dirByte & (1 << 1));
        $deg45 = (bool)($dirByte & (1 << 2));
        $direction = ($frontBack ? 'b' : 'f') . ($leftRight ? 'l' : 'r');
        if ($deg45) {
            $direction = match ($direction) {
                'bl' => 'b-',
                'br' => '-r',
                'fl' => '-l',
                'fr' => 'f-',
            };
        }
        header('Character-Direction: ' . ($fullDirection = trim((match ($direction[0]) {
                            'f' => 'Front',
                            'b' => 'Back',
                            default => '-',
                        }) . '-' . (match ($direction[1]) {
                            'r' => 'Right',
                            'l' => 'Left',
                            default => '-',
                        }), '-')));
    } else {
        $dataView = null;
    }
    require_once 'getColor.php';
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
    <g><?= !$nowatermark ? '<rect width="440" height="100" fill="#fff100"/>' : '' ?></g>
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
    <g><?= '<!-- PHPX -->';
        if (!$nowatermark) require_once "{$_SERVER['DOCUMENT_ROOT']}/dollmaker2/watermark.svg.php";
        echo '<!-- PHPX -->' ?></g>
</svg>
