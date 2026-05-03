<?php require_once "{$_SERVER['DOCUMENT_ROOT']}/require/createHead2.php";

use ANTHeader\ANTNavLinkTag;
use DataViewed\BinaryView;
use ANTHeader\ANTNavIStyle;
use ANTHeader\ANTNavOption;
use function ANTHeader\ANTNavHome;
use function ANTHeader\create_head2;
use function Helpers\htmlspecialchars12;

require_once "BinaryHelper.php";

if (preg_match('/^v(\\d+)([uz])\\.([A-Za-z0-9\\-_]+)$/D', $_GET['dna'], $matches)) {
    if ($matches[2] === 'z') {
        $dataView = BinaryView::fromBase58($matches[3]);
    } else {
        $dataView = BinaryView::fromBase64URL($matches[3]);
    }
    $canonicalDNA = "v1u.{$dataView->toBase64URL()}";
} else {
    $dataView = null;
    $canonicalDNA = 'v1u.AKjz_wCo8__-4bn_AFh__wBGZf8ALUD___EA_w';
}
require_once 'getColor.php';
global $colors;
$links = create_head2('Character Customizer Version5', [
        'base' => '/dollmaker3/',], [
        new ANTNavLinkTag('stylesheet', [
                'styles.css', 'ddDL-table.css',
        ]),// new ANTNavIStyle('.divs{max-width:650px}'),
        new ANTNavIStyle('div.divs.nav-home{max-width:unset;}'),
        new ANTNavIStyle('h1{margin-top:0;}'),
        new ANTNavLinkTag('canonical', "http://localhost/dollmaker3/$canonicalDNA/"),
    //new ANTNavLinkTag('canonical', "https://antrequest.nl/dollmaker3/$canonicalDNA/"),
], [ANTNavHome(),
        new ANTNavOption('/dollmaker3/', '/dollmaker2/icon/endpoint.php?preset=Bee',
                'dollmakerV4 ANT', new Color('a68300'),
                new Color('fff100'), true),
]); ?>
<div class=divs>
    <h1><a href=?>Character Customizer Version4 of ANT.Ractoc.com</a></h1>
    <div><p>copyright &copy; all rights reversed</div>
    <form method=post action=oninput.php>
        <div><?= "<img src=\"endpoint.svg.php?" . htmlspecialchars12($_SERVER['QUERY_STRING'])
            . "\" id=main-svg width=800 height=1280 alt='the result'>" . (function () use ($colors) {
                $thead = '<table style=display:inline-table><thead><tr><th scope=col>Description' .
                        '<th scope=col>Color Selector<th scope=col>Original Selection</thead>';
                $result = '';
                foreach ($colors as $name => $color) {
                    $result .= "<tr><td><label for=color-$name>$name:</label><td><input name=$name id=color-$name value"
                            . "=\"$color\" size=7 type=color><td style=background-color:$color><span>$color</span>";
                }
                return "$thead<tbody>$result</tbody><tfoot><tr><td colspan=3><button type=submit>apply colors</button>";
            })() . '</table>' ?></div>
        <div hidden><?= (function () {
                foreach (['Front', 'Back', 'Right', 'Left'] as $z)
                    echo "<div><label for=$z>$z:<input type=radio name=direction value=$z id=$z></label></div>";
                foreach (['Right', 'Left'] as $x)
                    foreach (['Front', 'Back'] as $y)
                        echo "<div><label for=$y-$x>$y-$x:<input type=radio name=direction value=$y-$x id=$y-$x></label></div>";
            })() ?></div>
    </form>
</div>
<div class=divs><?= (function () {
        $json = json_decode(file_get_contents(__DIR__ . '/assets/assets.json'), true);
        echo '<pre>'.htmlspecialchars12(\Helpers\json_fromArray($json)).'</pre>';
    })() ?></div>
