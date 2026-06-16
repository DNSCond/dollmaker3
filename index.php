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
        new ANTNavLinkTag('stylesheet', ['styles.css', 'ddDL-table.css',]),
        new ANTNavIStyle('div.divs.nav-home{max-width:unset;}'), new ANTNavIStyle('h1{margin-top:0;}'),
        new ANTNavLinkTag('canonical', "https://localhost/dollmaker3/{$GLOBALS['canonicalFullString']}"),
    //new ANTNavLinkTag('canonical', "https://antrequest.nl/dollmaker3/{$GLOBALS['canonicalFullString']}"),
        new ANTNavArbitraryHTML('open-graph',
                "<meta property=og:description content=\"ANTRequest.nl's Character Creator, create your ANTRequest.nl's Character lookalike here\">" .
                "<meta property=og:title content=\"Character Customizer Version5\">" .
                "<meta property=og:url content=https://antrequest.nl/dollmaker3/{$GLOBALS['canonicalFullString']}>" .
                "<meta property=og:image content=\"https://localhost/dollmaker3/endpoint.svg.php?" . htmlspecialchars12($_SERVER['QUERY_STRING']) . '">' .
                "<meta property=og:image:width content=800><meta property=og:image:height content=1280>" .
                "<meta property=og:image:type content=image/svg+xml>"),
        new ANTNavArbitraryHTML('preload', '<link rel=preload href=ddDL-table.css as=style><link rel=preload href=display.css as=style>'),
], [ANTNavHome(),
        new ANTNavOption('/dollmaker3/', '/dollmaker2/icon/endpoint.php?preset=Bee',
                'dollmakerV4 ANT', new Color('a68300'),
                new Color('fff100'), true),
]); ?>
<div class=divs>
    <h1><a href=?>Character Customizer Version5</a></h1>
    <div><p>copyright &copy; all rights reversed</div>
    <script type=application/json is=output-script><?= json_encode([
                '$colors' => $colors, 'direction' => ['horizontal' => $GLOBALS['x'], 'vertical' => $GLOBALS['y']],
                'assets' => $GLOBALS['assets-'],
        ], JSON_INVALID_UTF8_SUBSTITUTE) ?></script>
    <script type=module src=/gallery/JSONScript.js></script>
    <form method=post action=oninput.php>
        <div><?= "<img src=\"endpoint.svg.php?" . htmlspecialchars12($_SERVER['QUERY_STRING'])
            . "\" id=main-svg width=800 height=1280 alt='the result'>" . (function () use ($colors) {
                $thead = '<table style=display:inline-table><thead><tr><th scope=col>Description' .
                        '<th scope=col>Color Selector<th scope=col>Original Selection</thead>';
                $result = '';
                foreach ($colors as $name => $color) {
                    $result .= "\n<tr><td><label for=color-$name>$name:</label><td><input name=$name id=color-$name" .
                            " value=\"$color\" size=7 type=color><td style=background-color:$color><span>$color</span>";
                }
                return "$thead<tbody>$result</tbody><tfoot><tr><td colspan=3><label>\$opaque <input name=opaque" .
                        " type=checkbox></label><tr><td colspan=3><button type=submit>apply colors</button>";
            })() . '</table>' ?></div>
        <div hidden><?= (function () {
                //$result = '';foreach (['Front', 'Back', 'Right', 'Left'] as $z)
                //$result .= "<div><label for=$z>$z:<input type=radio name=direction value=$z id=$z></label></div>";
                //foreach (['Right', 'Left'] as $x) foreach (['Front', 'Back'] as $y)$result .=
                // "<div><label for=dir-$y-$x>$y-$x:<input type=radio name=direction value=$y-$x id=dir-$y-$x></label></div>";
                return '';
            })() ?></div>
    </form>
</div>
<template id=CharacterDisplay_template>
    <!--<?= 'PHPTP';
    ob_start(); ?>-->
    <link rel=stylesheet href=ddDL-table.css>
    <link rel=stylesheet href=display.css>
    <div style=padding:0.5em>
        <span><slot name=accessory-name>Accessory Name</slot></span>
    </div>
    <div><?= /** @noinspection RequiredAttributes */
        "<img data-img-src alt=\"Equip \$AccessoryName\" width=800 height=1280 class=store-img>" ?></div>
    <dl class=descLi style=border-bottom:none;border-left:none;border-right:none>
        <div data-key=cost>
            <dt>cost</dt>
            <dd>
                <slot name=cost>Unknown</slot>
        </div>
    </dl>
    <!--<?= 'PHPTP';
    $templateContent = ob_get_flush();
    $templateContent = preg_replace('/\\s+/', ' ', $templateContent);
    $templateContent = preg_replace('/\\s+<!--PHPTP$/D', '', $templateContent);
    $templateContent = preg_replace('/^-->\\s+/', '', $templateContent) ?>-->
</template>
<div class=divs><?= "\n";
    $afterColors = (7 * 4);
    $filegc = file_get_contents(__DIR__ . '/store/assets.json');
    if ($filegc) $json = json_decode($filegc, true); else $json = array('failure');
    echo '<script type=application/json is=output-script>' . json_encode($json, JSON_INVALID_UTF8_SUBSTITUTE) . '</script>';
    foreach ($json['assets'] as $key => $item) {
        if (array_key_exists('private', $item) && $item['private']) continue;
        $htmlName = htmlspecialchars12($item['name']);
        $view = BinaryView::fromBase64URL($GLOBALS['canonicalB64']);
        $totalAssets = 2; // Or count($your_assets_array)
        $view->resize($afterColors + 2 + ($totalAssets * 3));
        if (!preg_match('/^(\\d+)/', $key, $matches)) continue;

        // 1. Force preserve or set the character direction/global options flag
        // Use the global $dirByte variable from your decoder script
        $view->setUint8($afterColors, $GLOBALS['dirByte'] ?? 0b100);

        // 2. Set the Asset Count to 1
        $view->setUint8($afterColors + 1, 2);

        // 3. Write the Asset ID (takes offsets 30 and 31)
        $view->setUint16($afterColors + 2, (int)$matches[1]);

        // 4. Write the Asset Option (offset 32)
        $view->setUint8($afterColors + 4, 0);

        // 5. put the body in it
        $view->setUint16($afterColors + 5, 1);

        // 4. Write the Asset Option
        $view->setUint8($afterColors + 7, 0);

        //$htmlName.=' '.+$matches[1];
        $img_src = htmlspecialchars12("endpoint.svg.php?dna=v1u.{$view->toBase64URL()}");
        $content = str_replace('data-img-src', "src=\"$img_src\"", $templateContent);
        $content = str_replace('$AccessoryName', $htmlName, $content);
        if (array_key_exists('cost', $item)) $cost = match ($item['cost']) {
            true => 'default',
            false => 'Off Sale',
            0 => 'Free',
            default => "{$item['cost']} units",
        }; else $cost = 'Free';
        echo "<character-display img-src=\"$img_src\"><template shadowrootmode=open>$content</template>" .
                "<span slot=accessory-name>$htmlName</span><span slot=cost>$cost</span></character-display>\n";
    } ?></div>
<script type=module>
    class CharacterDisplay extends HTMLElement {
        static get observedAttributes() {
            return Array();//['img-src'];
        }

        get [Symbol.toStringTag]() {
            return 'HTML_' + this.constructor.name?.toUpperCase();
        }

        constructor() {
            super();
            //const clone = document.getElementById('CharacterDisplay_template').content.cloneNode(true);
            //this.attachShadow({mode: 'open'}).append(clone);
        }

        connectedCallback() {
            this.shadowRoot.querySelector('img.store-img').src = this.getAttribute('img-src');
            /*const attr = this.getAttribute('asset-data');
            if (attr) {
                const pre = document.createElement('pre'),
                    code = document.createElement('code');
                pre.append(code);
                code.append(JSON.stringify(JSON.parse(attr), null, 2));
                this.shadowRoot.append(pre);
            }*/
        }

        attributeChangedCallback(name, _oldValue, newValue) {
            this.shadowRoot.querySelector('img.store-img').src = newValue;
        }
    }

    // customElements.define('character-display', CharacterDisplay);
    // await customElements.whenDefined('character-display');
</script>
