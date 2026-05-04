<?php /** @noinspection HtmlUnknownTarget */
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/createHead2.php";

use ANTHeader\ANTNavIStyle;
use ANTHeader\ANTNavLinkTag;
use ANTHeader\ANTNavOption;
use DataViewed\BinaryView;
use function ANTHeader\ANTNavHome;
use function ANTHeader\create_head2;
use function Helpers\htmlspecialchars12;

$GLOBALS['canonical_redir_path'] = '/dollmaker3/';
require_once "preprocessor.php";
global $colors;
$links = create_head2('Character Customizer Version5', [
        'base' => '/dollmaker3/',], [
        new ANTNavLinkTag('stylesheet', [
                'styles.css', 'ddDL-table.css',
        ]),// new ANTNavIStyle('.divs{max-width:650px}'),
        new ANTNavIStyle('div.divs.nav-home{max-width:unset;}'),
        new ANTNavIStyle('h1{margin-top:0;}'),
        new ANTNavLinkTag('canonical', "http://localhost/dollmaker3/{$GLOBALS['canonicalFullString']}"),
    //new ANTNavLinkTag('canonical', "https://antrequest.nl/dollmaker3/{$GLOBALS['canonicalFullString']}/"),
], [ANTNavHome(),
        new ANTNavOption('/dollmaker3/', '/dollmaker2/icon/endpoint.php?preset=Bee',
                'dollmakerV4 ANT', new Color('a68300'),
                new Color('fff100'), true),
]); ?>
<div class=divs>
    <h1><a href=?>Character Customizer Version4 of ANT.Ractoc.com</a></h1>
    <div><p>copyright &copy; all rights reversed</div>
    <form method=post action=oninput.php>
        <div><?= /*"<img src=\"endpoint.svg.php?" . htmlspecialchars12($_SERVER['QUERY_STRING'])
            . "\" id=main-svg width=800 height=1280 alt='the result'>" .*/
            (function () use ($colors) {
                $thead = '<table style=display:inline-table><thead><tr><th scope=col>Description' .
                        '<th scope=col>Color Selector<th scope=col>Original Selection</thead>';
                $result = '';
                foreach ($colors as $name => $color) {
                    $result .= "\n<tr><td><label for=color-$name>$name:</label><td><input name=$name id=color-$name" .
                            " value=\"$color\" size=7 type=color><td style=background-color:$color><span>$color</span>";
                }
                return "$thead<tbody>$result</tbody><tfoot><tr><td colspan=3><button type=submit>apply colors</button>";
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
        "<img data-img-src alt=\"Equip \$AccessoryName\" width=800 height=1280 class=store-img>"; ?></div>
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
    $json = json_decode(file_get_contents(__DIR__ . '/assets/assets.json'), true);
    foreach ($json['anime'] as $key => $item) {
        if (array_key_exists('private', $item) && $item['private']) continue;
        $htmlName = htmlspecialchars12($item['name']);
        $view = BinaryView::fromBase64URL($GLOBALS['canonicalB64']);
        $view->resize((7 * 4) + (2 + 3));
        if (!preg_match('/^(\\d+)/', $key, $matches)) continue;

        $view->setUint8((7 * 4) + 1, 1); // count
        $view->setUint16((7 * 4) + 2, +$matches[1]);
        $view->setUint8((7 * 4) + 3, 210); // options
        $htmlName .= ' ' . +$matches[1];
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
