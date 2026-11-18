<?php use DataViewed\BinaryView;
use function ANTHeader\create_head3;
use function DataViewed\RGBToRGBA32;
use function Helpers\Getters\getThingOrNull;
use function Helpers\Getters\isPresent;

function htmlspecialchars12(string $value): string
{
    return htmlspecialchars($value, ENT_HTML5 | ENT_QUOTES | ENT_SUBSTITUTE);
}

$GLOBALS['canonical_redir_path'] = '/dollmaker3/';
require_once "preprocessor.php";
global $colors, $assetdata;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'Character Customizer', [
        'desc' => 'ANTRequest.nl\'s Character Creator, create your ANTRequest.nl\'s Character lookalike here',
        'stylelinks' => ['statics/styles.css', 'statics/ddDL-table.css', 'statics/display.css'],
        'canonical' => "https://antrequest.nl/dollmaker3/{$GLOBALS['canonicalFullString']}",
        'base' => '/dollmaker3/',
]);
global $opaque, $pfpMode;
$GLOBALS['inherited'] = true;
$isopaque = $opaque ? 'checked' : 'data-checked';
$pfpEnabled = $pfpMode ? 'checked' : 'data-check';
if ($pfpMode) {
    $w = 512;
    $h = 512;
} else {
    $w = 800;
    $h = 1280;
}
$size = "width=$w height=$h";
$mainSize = $size . ($pfpMode ? "\x20class=size512" : '');
$htmlQuery = htmlspecialchars12($_SERVER['QUERY_STRING']) ?>
<div class=divs>
    <h1><a href=?><?= $title ?></a></h1>
    <form method=post action=oninput.php>
        <div><?= "<img src=\"endpoint.svg.php?$htmlQuery\" id=main-svg $mainSize alt='the result'>";
            $thead = '<table class=inline-table><thead><tr><th scope=col>Description<th' .
                    ' scope=col>Color Selector<th scope=col>Original Selection</thead>';
            $index = 0;
            $result = '';
            $type = 'text';
            if (array_key_exists('optiontype', $_GET)) {
                $type = match ("{$_GET['optiontype']}") {
                    'select' => 'select',
                    'color' => 'color',
                    'text' => 'text',
                    default => $type,
                };
            }
            $view = BinaryView::fromBase64URL($GLOBALS['canonicalB64']);
            require_once 'preselected-colors.php';
            foreach ($colors as $name => $color) {
                $result .= "\n<tr><td><label for=color-$name>$name:</label><td>";
                if ($type === 'select') {
                    $result .= preselectedcolors($name, $color);
                } else {
                    $result .= "<input name=$name id=color-$name value=\"$color\" size=7 type=$type required pattern=^#[a-f0-9]{6}$>";
                }
                $result .= "<td class=bg data-ori=$color><span>$color</span>";
                if ($name === 'skin') $index++; else {
                    RGBToRGBA32($view, hexdec(trim($color, '#')) ^ 0xffFFff, $index++ * 4);
                }
            }
            echo "$thead<tbody>$result</tbody><tfoot><tr><td><label for=opaque>opaque</label><td><input name" .
                    "=opaque type=checkbox $isopaque id=opaque><td>" . ($isopaque === 'checked' ? 'On' : 'Off') .
                    "<tr><td><label for=pfpMode>Profile Image Mode</label><td><input name=pfpMode $pfpEnabled" .
                    " id=pfpMode type=checkbox><TD>" . ($pfpEnabled === 'checked' ? 'On' : 'Off') . '<tr><td ' .
                    "colspan=3><button type=submit>apply colors</button></table><div class=inline-block>" .
                    "<button type=button class=convertpng>Convert to PNG</button>, <a href=v1u." .
                    "{$view->toBase64URL()}>Invert Colors</a></div>" ?></div>
        <DETAILS class=presel><?= "<summary>Preselectable Colors</summary><h2>Preselectable Colors</h2>";
            global $preselectedcolors;
            foreach ($preselectedcolors as $outer => $colorsArray) {
                echo '<h3>' . htmlspecialchars12($outer) . '</h3>';
                foreach ($colorsArray as $key => $val) {
                    /** @noinspection CssUnresolvedCustomProperty */
                    $innerHTML = "<template shadowrootmode=open><link rel=stylesheet href=colors/inner.css>" .
                            "<div class=outer data-val=$val><span class=inner><slot></slot></span></div>";
                    echo "<color-block color=$val>$innerHTML</template>&quot;$key&quot; $val;</color-block>";
                }
            } ?></DETAILS>
        <div hidden><?= (function () {
                $result = '';
                foreach (['Front', 'Back', 'Right', 'Left'] as $z)
                    $result .= "<div><label for=$z>$z:<input type=radio name=direction value=$z id=$z></label></div>";
                foreach (['Right', 'Left'] as $x) foreach (['Front', 'Back'] as $y) $result .= "<div><label for=dir-"
                        . "$y-$x>$y-$x:<input type=radio name=direction value=$y-$x id=dir-$y-$x></label></div>";
                return $result;
            })();
            $mapped = array_map(fn($mapped) => +$mapped['id'], $GLOBALS['assets-']);
            foreach ($mapped as $id) if (in_array($id, $mapped))
                echo "<input type=hidden value=$id name=assets[]>" ?></div>
    </form>
</div>
<SCRIPT type=module src=statics/index.js></SCRIPT>
<form class=divs method=post action=oninput.php><?= "<H2>Store</H2>";
    $afterColors = (7 * 4);
    global $assetOptions;
    if ($pfpMode) echo "<input type=hidden value=on name=pfpMode>";
    foreach ($colors as $name => $color) echo "<input type=hidden value=$color name=$name>";
    echo "\n<div class=marginal><button type=submit>apply preview</button></div>";
    foreach ($assetdata['d'] as $key => $item) {
        $item = $item['f-']['data'];
        if (!is_array($item)) continue;
        if (array_key_exists('private', $item) && $item['private']) continue;
        $htmlName = htmlspecialchars12($item['name']);
        $view = BinaryView::fromBase64URL($GLOBALS['canonicalB64']);
        if (!preg_match('/^(\\d+)/', $key, $matches)) continue;
        $writeCount = 1;
        if (array_key_exists('baseBody', $item)) $writeCount++;

        $view->resize($afterColors + 2);
        $view->resize($afterColors + 2 + ($writeCount * 3));
        $view->setUint8($afterColors + 1, $writeCount);
        $view->setUint8($afterColors, ($GLOBALS['dirByte'] ?? 0b100));
        $baseOffset = $afterColors + 2;
        $assetIdx = 0;

        // Asset 1: Primary Asset
        $view->setUint16($baseOffset + ($assetIdx * 3), (int)$matches[1]);
        $view->setUint8($baseOffset + ($assetIdx * 3) + 2, 0);
        $assetIdx++;

        if (array_key_exists('baseBody', $item)) {
            $view->setUint16($baseOffset + ($assetIdx * 3), $item['baseBody']);
            $view->setUint8($baseOffset + ($assetIdx * 3) + 2, 0);
            $assetIdx++;
        }

        if (array_key_exists('cost', $item)) $cost = match ($item['cost']) {
            false => 'Off Sale',
            true => 'default',
            null, 0 => 'Free',
            default => "{$item['cost']} units",
        }; else $cost = 'Free';
        $img_src = htmlspecialchars12("endpoint.svg.php?dna=v1u.{$view->toBase64URL()}");
        $inputname = "asset-$matches[1]";
        $integerid = +$matches[1];
        $iname = 'assets[]';
        if (in_array($integerid, $mapped)) $iname = "$iname\x20checked";
        echo "<character-display><div class=padding><label for=$inputname>$htmlName <input" .
                " type=checkbox value=$integerid id=$inputname name=$iname></label></div>" .
                "<div><label for=$inputname><img src=\"$img_src\" alt=\"Equip $htmlName\"" .
                " $size class=store-img loading=lazy></label></div><dl class=descLi><div da" .
                "ta-key=cost><dt>cost<dd>$cost</div><div data-key=id><dt>id<dd>$matches[1]" .
                "</div></dl><div class=options>";
        $options = $assetOptions[$integerid];
        for ($i = 0; $i < 3; $i++) {
            $nullOption = false;
            $enabled = isPresent($item, ['options', "$i"]);
            if ($enabled && !is_string($item['options'][$i])) {
                $enabled = false;
                $nullOption = true;
            }
            $disabled = !$enabled ? 'disabled' : '';
            $checked = $options & 1 << $i ? 'checked' : '';
            echo "<div><label><input type=checkbox name={$inputname}_$i $checked $disabled>\x20";
            if ($nullOption) {
                echo "Unusable\x20" . ($i + 1);
            } elseif ($enabled) {
                echo htmlspecialchars12("{$item['options'][$i]}");
            } else echo "Unknown\x20" . ($i + 1);
            echo "</label></div>";
        }
        echo "</div></character-display>";
    }
    global $dirByte;
    echo "\n<div class=marginal2><button type=submit>apply preview</button></div>" ?></form>
<DIV class=divs>
    <H2 ID=checkout>Checkout</H2>
    <DETAILS OPEN><?= '<SUMMARY>View Checkout</SUMMARY>';
        $count = !!count($GLOBALS['assets-']);
        if ($count) {
            echo '<TABLE CLASS=mt><THEAD><TR><TH SCOPE=col>Item Name<TH SCOPE=col>Item Price<tBODY>';
        } else echo "<p>No Checkout Needed.";
        $assetCheckout = array();
        global $direction;
        $assetCheckoutTotal = 0;
        foreach ($GLOBALS['assets-'] as $asset) {
            $antiNull = str_pad("{$asset['id']}", 4, '0', STR_PAD_LEFT);
            if (is_null($dataThis = getThingOrNull($assetdata,
                    ['d', $antiNull, $direction, 'data']))) continue;
            $asset['name'] = $dataThis['name'];
            $asset['cost'] = $dataThis['cost'];
            $assetCheckout[] = $asset;
            $cost = match ($asset['cost']) {
                false => 'Off Sale',
                true => 'default',
                null, 0 => 'Free',
                default => "{$asset['cost']} units",
            };
            if (is_integer($asset['cost'])) $assetCheckoutTotal += $asset['cost'];
            if ($count) echo "<TR><TD>{$asset['name']}<TD>$cost";
        }
        if ($count) echo "<tFoot><TR><TH COLSPAN=1 SCOPE=row>Total<TD>$assetCheckoutTotal Units</TABLE>" ?></DETAILS>
</DIV>
<SCRIPT type=application/json is=output-script><?= json_encode([
            '$colors' => $colors, 'direction' => ['horizontal' => $GLOBALS['x'], 'vertical' => $GLOBALS['y']],
            'currentlyEquipped' => $assetCheckout, 'assetCheckoutTotal' => $assetCheckoutTotal,
    ], JSON_INVALID_UTF8_SUBSTITUTE) ?></SCRIPT>
<div class=divs><?= "<h2 class='store-header preset-h2'>Presets</h2>" . (function () {
        $array = array(
                'Sun' => 'v1u._1WU_f9VvP3_ZZW9_1W8_f80JNH_JSgs_wDx_QQD0AcA0QcA1AcA',
                'Moon' => 'v1u._3AZGf_tzan_0eD9__j9jP_9wIX_6cyF_wDx_QQD0AcA0QcA0wcA',
                'V3id' => 'v1u._wAspP_9_f3_ueH8_wCkAP-kcQD_vYnk_wDx_QQC0AcB0QcB',
                'Card Basic 2' => 'v1u._x28Ff8dvBX_ueH8_2QMdP_Y6K3_0DFt_wDx_QQEAQABAgABBgABBwAB',
                'Lime Like' => 'v1u._yyVWf8slVn_ueH8_13xhP_8Can_hCAh_wDx_QQCAQABAgAB',
                'Red' => 'v1u._1xtHP9sVR3_ueH8_xkQ5P_s2Uz_uWWg_wDx_QQCugsAvAsA',
                'Peasant' => 'v1u._wR9Zf8EfWX_ueH8_6Ro6P9QcLT_iWTE_wDx_QQFAQABAgABAwABBgABBwAB',
                'Fire' => 'v1u._1WU_f9VlP3_ZZW9_1W8_f80JNH_JSgs_wAAgAQDAQABAgABBwAB',
                'randInt' => 'v1u._5HYqP-lBSX_1UlZ_wgZGf_0EQz__Vhx_1QtzQQFAQAABAAABQAABwAA1AcA',
                'some?' => 'v1u.__QtRf8ZkQz_ueH8_8T96f99uMX_nZGU_-jcUQQD0AcA0QcA0gcA',
                'v1u._4llUf-gBcj_ueH8_wlZ4P_dcGD_fE1R_0glfQQBAQAA',
                'bright' => 'v1u.__zpcf9cJEH_ueH8_yj44f_Qyf3_DNXw_1z1MAQE0AcA0gcA0wcA1AcA',
                'dark' => 'v1u._7k1nf9JRLX_ueH8_1ksif_UzBz_5HwU_7hdZAQD0AcA0gcA0wcA',
                'v1u._3VN1f8szeD_ueH8__GYTP_obVT_MDm9_zgYzAQDAQAAAwAABgAA',
                'v1u._8WZ-P-wDFj_ueH8_2CtWf_4tAX_9IWM_yh1eAQCAQAAAwAA',
                'v1u._zwcmf_9_f3_ueH8_zEVff8lEGX_GQxA_wDx_QQD0AcA0gcA0wcA',
                'v1u._x28Ff_9_f3_ueH8_2QMdP_Y6K3_0DFt_wDx_QQEBgAABwAA0AcA3wcD',
                'v1u._wR9Zf_9_f3_ueH8_6Ro6P9QcLT_iWTE_wDx_QQFBQAABgAABwAA0AcA4AcA',
                'v1u.__3RWf8AAAD_ueH8__1Z_f9ZjP3_QHQZ__0MAAQCuAsAuQsA',
                'New Ciolor' => 'v1u._-R9GP8NDJn_ueH8_8CxAf8F3JT_iSyU_3ip7AQCugsAuwsA',
        ); // f4e0f0; 78bdf8
        $output = [];
        foreach ($array as $name => $href) {
            $output[] = "<div class=store-div><div CLASS=padding><a href=\"$href\">$name</a></div>" .
                    "<a href=\"$href\"><img src=\"endpoint.svg.php?dna=$href\" class=store-img width" .
                    "=800 height=1280 alt=\"clothing option &quot;$name&quot;\" loading=lazy></a></div>";
        }
        return "\n" . implode("", $output);
    })() . "\n" ?></div>
