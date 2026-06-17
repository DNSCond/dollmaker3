<?php /** @noinspection HtmlUnknownTarget */
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/createHead2.php";

use DataViewed\BinaryView;
use ANTHeader\ANTNavIStyle;
use ANTHeader\ANTNavOption;
use ANTHeader\ANTNavLinkTag;
use ANTHeader\ANTNavArbitraryHTML;
use function ANTHeader\ANTNavHome;
use function ANTHeader\create_head2;

function htmlspecialchars12(string $value): string
{
    return htmlspecialchars($value, ENT_HTML5 | ENT_QUOTES | ENT_SUBSTITUTE);
}

$GLOBALS['canonical_redir_path'] = '/dollmaker3/';
require_once "preprocessor.php";
global $colors;
$links = create_head2('Character Customizer Version5', [
        'base' => '/dollmaker3/', 'desc' => 'ANTRequest.nl\'s Character Creator, create your ANTRequest.nl\'s Character lookalike here'], [
        new ANTNavLinkTag('stylesheet', ['styles.css', 'ddDL-table.css', 'display.css']),
        new ANTNavIStyle('div.divs.nav-home{max-width:unset;}'), new ANTNavIStyle('h1{margin-top:0;}'),
        new ANTNavLinkTag('canonical', "https://antrequest.nl/dollmaker3/{$GLOBALS['canonicalFullString']}"),
    //new ANTNavArbitraryHTML('open-graph',
    //"<meta property=og:description content=\"ANTRequest.nl's Character Creator, create your ANTRequest.nl's Character lookalike here\">" .
    //"<meta property=og:title content=\"Character Customizer Version5\">" .
    //"<meta property=og:url content=https://antrequest.nl/dollmaker3/{$GLOBALS['canonicalFullString']}>" .
    //"<meta property=og:image content=\"https://localhost/dollmaker3/endpoint.svg.php?" . htmlspecialchars12($_SERVER['QUERY_STRING']) . '">' .
    //"<meta property=og:image:width content=800><meta property=og:image:height content=1280>" .
    //"<meta property=og:image:type content=image/svg+xml>"),
], [ANTNavHome(),
        new ANTNavOption('/dollmaker3/', '/dollmaker2/icon/endpoint.php?preset=Bee',
                'dollmakerV4 ANT', new Color('a68300'),
                new Color('fff100'), true),
]);
global $opaque;
$isopaque = $opaque ? 'checked' : 'data-checked'; ?>
<div class=divs>
    <h1><a href=?>Character Customizer Version5</a></h1>
    <div><p>copyright &copy; all rights reversed</div>
    <script type=module src=/gallery/JSONScript.js></script>
    <form method=post action=oninput.php>
        <div><?= "<img src=\"endpoint.svg.php?" . htmlspecialchars12($_SERVER['QUERY_STRING'])
            . "\" id=main-svg width=800 height=1280 alt='the result'>" . (function () use ($isopaque, $colors) {
                $thead = '<table style=display:inline-table><thead><tr><th scope=col>Description' .
                        '<th scope=col>Color Selector<th scope=col>Original Selection</thead>';
                $result = '';
                foreach ($colors as $name => $color) {
                    //$result .= "\n<tr><td><label for=color-$name>$name:</label><td><input name=$name id=color-$name" .
                    //" value=\"$color\" type=color><td style=background-color:$color><span>$color</span>";
                    $result .= "\n<tr><td><label for=color-$name>$name:</label><td><input name=$name" .
                            " id=color-$name value=\"$color\" size=7 type=text pattern=^#[a-f0-9]{6}$>" .
                            "<td style=background-color:$color><span>$color</span>";
                }
                return "$thead<tbody>$result</tbody><tfoot><tr><td><label>\$opaque <input name=opaque type" .
                        "=checkbox $isopaque></label><td colspan=2><button type=button class=convertpng>" .
                        "Convert to PNG</button><tr><td colspan=3><button type=submit>apply colors</button>";
            })() . '</table>' ?></div>
        <div hidden><?= (function () {
                //$result = '';foreach (['Front', 'Back', 'Right', 'Left'] as $z)
                //$result .= "<div><label for=$z>$z:<input type=radio name=direction value=$z id=$z></label></div>";
                //foreach (['Right', 'Left'] as $x) foreach (['Front', 'Back'] as $y)$result .=
                //"<div><label for=dir-$y-$x>$y-$x:<input type=radio name=direction value=$y-$x id=dir-$y-$x></label></div>";
                return '';
            })() ?></div>
        <div hidden><?= '<!--assets-->';
            $mapped = array_map(fn($mapped) => +$mapped['id'], $GLOBALS['assets-']);
            foreach ($mapped as $id) if (in_array($id, $mapped))
                echo "<input type=hidden value=$id name=assets[]>" ?></div>
    </form>
</div>
<!--suppress JSCheckFunctionSignatures, JSUnresolvedReference -->
<script type=module>
    const img = document.querySelector('#main-svg'), a = document.createElement('a');
    document.querySelector('button[type=button].convertpng').addEventListener('click',
        () => createImageBitmap(img).then(imageBitmap => {
            const canvas = new OffscreenCanvas(imageBitmap.width, imageBitmap.height);
            canvas.getContext("2d").drawImage(imageBitmap, 0, 0);
            return canvas.convertToBlob();
        }).then(blob => {
            a.download =  Date();
            const blobHref = a.href = URL.createObjectURL(blob);
            document.body.append(a);a.click();
            return new Promise(resolve => setTimeout(resolve, 5000, blobHref));
        }).then(URL.revokeObjectURL).finally(() => a.remove())
    );
</script>
<form class=divs method=post action=oninput.php><?= "<!-- HTTPS QUERY -->";
    $afterColors = (7 * 4);
    foreach ($colors as $name => $color) {
        echo "<input type=hidden value=$color name=$name>";
    }
    $filegc = file_get_contents(__DIR__ . '/store/assets.json');
    if ($filegc) $json = json_decode($filegc, true); else $json = array('failure');
    //echo"\n<script type=application/json is=output-script>".
    //json_encode($json,JSON_INVALID_UTF8_SUBSTITUTE)."</script>\n";
    foreach ($json['assets'] as $key => $item) {
        if (array_key_exists('private', $item) && $item['private']) continue;
        $htmlName = htmlspecialchars12($item['name']);
        $view = BinaryView::fromBase64URL($GLOBALS['canonicalB64']);
        $totalAssets = 2; // Or count($your_assets_array)
        $view->resize($afterColors + 2);
        $view->resize($afterColors + 2 + ($totalAssets * 3));
        if (!preg_match('/^(\\d+)/', $key, $matches)) continue;

        // 1. Force preserve or set the character direction/global options flag
        // Use the global $dirByte variable from your decoder script
        $view->setUint8($afterColors, $GLOBALS['dirByte'] ?? 0b100);

        // 2. Set the Asset Count to 2
        $view->setUint8($afterColors + 1, 2);
        {
            // 3. Write the Asset ID (takes offsets 30 and 31)
            $view->setUint16($afterColors + 2, (int)$matches[1]);

            // 4. Write the Asset Option (offset 32)
            $view->setUint8($afterColors + 4, 0);
        }
        if (array_key_exists('baseBody', $item)) {
            $view->setUint16($afterColors + 5, $item['baseBody']);
            $view->setUint8($afterColors + 7, 2);
        }
        if (array_key_exists('cost', $item)) $cost = match ($item['cost']) {
            true => 'default',
            false => 'Off Sale',
            0 => 'Free',
            default => "{$item['cost']} units",
        }; else $cost = 'Free';
        //$htmlName.=' '.+$matches[1];
        $img_src = htmlspecialchars12("endpoint.svg.php?dna=v1u.{$view->toBase64URL()}");
        $inputname = "asset-$matches[1]";
        $integerid = +$matches[1];
        $iname = 'assets[]';
        if (in_array($integerid, $mapped)) $iname = "$iname\x20checked";
        echo "<character-display><div style=padding:0.5em><label for=$inputname>$htmlName <input type=checkbox" .
                " value=$integerid id=$inputname name=$iname></label></div><div><img src=\"$img_src\" alt=\"" .
                "Equip $htmlName\" width=800 height=1280 class=store-img></div><dl class=descLi><div data-key="
                . "cost><dt>cost<dd><slot name=cost>$cost</slot></div></dl></character-display>";
    }
    echo "\n<div style='margin: 1em 0 1em 1em'><button type=submit>apply preview</button></div>"; ?></form>
<!--<script type=application/json is=output-script>&lt;?= json_encode([
'$colors' => $colors, 'direction' => ['horizontal' => $GLOBALS['x'], 'vertical' => $GLOBALS['y']],
'assets' => $GLOBALS['assets-'],], JSON_INVALID_UTF8_SUBSTITUTE) ?></script>-->
