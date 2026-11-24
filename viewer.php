<?php use DataViewed\BinaryView;
use function ANTHeader\create_head3;
use function DataViewed\RGBToRGBA32;
use function Helpers\Getters\getThingOrNull;
use function Helpers\Getters\isPresent;

function htmlspecialchars12(string $value): string
{
    return htmlspecialchars($value, ENT_HTML5 | ENT_QUOTES | ENT_SUBSTITUTE);
}

$bodyType = null;
if (array_key_exists('bodyType', $_GET) &&
        preg_match('/^[a-z\\-]+$/D', $_GET['bodyType'])) {
    $bodyType = $_GET['bodyType'];
} else {
    http_response_code(303);
    header("Location: /dollmaker3/");
    exit;
}
$GLOBALS['canonical_redir_path'] = "/dollmaker3/_$bodyType/";
require_once "preprocessor.php";
global $colors, $assetdata, $opaque, $pfpMode, $colorList, $directionName;
require_once "{$_SERVER['DOCUMENT_ROOT']}/require/header3/head3.php";
create_head3($title = 'Character Customizer', [
        'desc' => 'ANTRequest.nl\'s Character Creator, create your ANTRequest.nl\'s Character lookalike here',
        'stylelinks' => ['statics/styles.css', 'statics/ddDL-table.css', 'statics/deg.css'], 'bread' => [
                array('text' => 'Favicond\'s Character Gallery', 'href' => '/'),
                array('text' => 'Character Customizer', 'href' => '/dollmaker3/'),
        ], 'base' => '/dollmaker3/',
]);
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

//function var_string(...$vars): false|string
//{ob_start();var_dump(...$vars);return ob_get_clean();}

$size = "width=$w height=$h";
$mainSize = $size . ($pfpMode ? "\x20class=size512" : '') ?>
<div class=divs>
    <h1><a href=?><?= $title ?></a></h1>
    <form method=post action=oninput.php>
        <div><?= (function () use ($size) {
                ob_start();
                $s = "id='main-svg'";
                require_once './endpoint.svg.php';
                $r = "id=main-svg\x20class=size512";
                $return = str_replace($s, $r, ob_get_clean());
                return trim(preg_replace('/\\s+/', "\x20", $return));
            })();
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
            global $colorsFull, $colorDisplayList;
            $view = BinaryView::fromBase64URL($GLOBALS['canonicalized_dnastring']);
            require_once 'preselected-colors.php';
            $colorsPull = completeColorArray($colors);
            foreach ($colorDisplayList as $name) {
                $color = $colorsPull[$name];
                $result .= "<tr><td><label for=color-$name>$name: </label><td>";
                if ($type === 'select') $result .= preselectedcolors($name, $color); else {
                    $result .= "<input name=$name id=color-$name value=\"$color\"" .
                            " size=7 type=$type required pattern=^#[a-f0-9]{6}$>";
                }
                $result .= "<td class=bg data-ori=$color><span>$color</span>";
                if ($name === 'skin') $index++; else {
                    RGBToRGBA32($view, hexdec(trim($color, '#')) ^ 0xffFFff, $index++ * 4);
                }
            }
            $result .= (function () use ($directionName) {
                $result = '';
                foreach (['Front', 'Back', 'Right', 'Left'] as $z) {
                    $checked = $z === "{$directionName['hori']}{$directionName['verti']}" ? 'Checked' : '';
                    if ("$z" !== 'Front') $checked .= "\x20disabled";
                    $result .= "<TR><TD><label for=dir-$z>$z: </label><TD><input name=direction type" .
                            "=radio $checked value=$z id=dir-$z><TD>" . ($checked ?: 'Unchecked');
                }
                foreach (['Right', 'Left'] as $x) foreach (['Front', 'Back'] as $y) {
                    $checked = "$y-$x" === "{$directionName['hori']}-{$directionName['verti']}" ? 'checked' : '';
                    if ("$y-$x" !== 'Front-Right') $checked .= "\x20disabled";
                    $result .= "<TR><TD><label for=dir-$y-$x>$y-$x: </label><TD><input type=radio name" .
                            "=direction $checked value=$y-$x id=dir-$y-$x><TD>" . ($checked ?: 'Unchecked');
                }
                return "$result";
            })();

            $clear = BinaryView::fromBase64URL($GLOBALS['canonicalized_serializedB64U']);
            $clear->resize(4 * ColorConstantIndex + 2 + 1);
            $clear->setUint8(4 * ColorConstantIndex + 2 + 1, 0);
            $clear = "_$bodyType/v2u.{$clear->toBase64URL()}";
            echo "$thead<tbody>$result</tbody><tfoot><tr><td><label for=opaque>opaque</label><td><input name" .
                    "=opaque type=checkbox $isopaque id=opaque><td>" . ($isopaque === 'checked' ? 'On' : 'Off') .
                    "<tr><td><label for=pfpMode>Profile Image Mode</label><td><input name=pfpMode $pfpEnabled" .
                    " id=pfpMode type=checkbox><TD>" . ($pfpEnabled === 'checked' ? 'On' : 'Off') . '<tr><td ' .
                    "colspan=3><button type=submit>apply colors</button></table><div class=inline-block><button " .
                    " type=button class=convertpng>Convert to PNG</button>, <a>Invert Colors</a>, <a href=$clear" .
                    ">Clear Assets</a></div>";
            $mapped = array_map(fn($mapped) => +$mapped['id'], $GLOBALS['assets-']);
            foreach ($mapped as $id) if (in_array($id, $mapped))
                echo "<input type=hidden value=$id name=assets[]>";
            if ($bodyType !== null) echo "<input type=hidden value='$bodyType' name=bodyType>" ?></div>
        <DETAILS class=presel><?= "<summary>Preselectable Colors</summary><h2>Preselectable Colors</h2>";
            global $preselectedcolors;
            foreach ($preselectedcolors as $outer => $colorsArray) {
                echo '<h3>' . htmlspecialchars12($outer) . '</h3>';
                foreach ($colorsArray as $key => $val) {
                    /** @noinspection CssUnresolvedCustomProperty */
                    $innerHTML = "<template shadowrootmode=open><link rel=stylesheet href=colors/inner.css>"
                            . "<div class=outer  data-val=$val><span class=inner><slot></slot></span></div>";
                    echo "<color-block color=$val>$innerHTML</template>&quot;$key&quot; $val;</color-block>";
                }
            }
            $c = $GLOBALS['canonicalized_serialized'] ?></DETAILS>
        <DETAILS class='presel padding-right'><?= "<summary>Big Image</summary>" .
            "<img src=img/$c $size alt='the result' id=main-img>" ?></DETAILS>
    </form>
</div>
<SCRIPT type=module src=statics/index.js></SCRIPT>
<form class=divs method=post action=oninput.php><?= "<H2 id=store>Store</H2>";
    $afterColors = (ColorConstantIndex * 4);
    global $direction, $assetHelper;
    $assetOptions = $assetHelper->getAssociativeAssets();
    if ($pfpMode) echo "<input type=hidden value=on name=pfpMode>";
    echo "<input type=hidden value='{$directionName['name']}' name=direction>";
    if ($bodyType !== null) echo "<input type=hidden value='$bodyType' name=bodyType>";
    foreach ($colors as $name => $color) echo "<input type=hidden value=$color name=$name>";
    echo "\n<div class=marginal><button type=submit>apply preview</button></div>";
    foreach ($assetdata['d'] as $key => $item) {
        if (!array_key_exists($direction, $item)) continue;
        $item = $item[$direction]['data'];
        if (!is_array($item)) continue;
        if (array_key_exists('private', $item) && $item['private']) continue;
        if (!preg_match('/^(\\d+)/', $key, $matches)) continue;
        if (array_key_exists('BaseBodyName', $item)) {
            if ("{$item['BaseBodyName']}" !== $bodyType && $bodyType !== 'legacy-all') continue;
        }
        $htmlName = htmlspecialchars12($item['name']);
        $view = new AssetHelper($GLOBALS['canonicalized_dnastring'], 2);
        $view->clearAssets();
        $view->addAsset(+$matches[1], 0);
        if (array_key_exists('baseBody', $item))
            $view->addAsset(+$item['baseBody'], 0);
        if (array_key_exists('cost', $item)) $cost = match ($item['cost']) {
            false => 'Off Sale',
            true => 'default',
            null, 0 => 'Free',
            default => "{$item['cost']} units",
        }; else $cost = 'Free';
        $img_src = htmlspecialchars12("img/v2u.{$view->toBase64URL()}");
        $inputname = "asset-$matches[1]";
        $integerid = +$matches[1];
        $iname = 'assets[]';
        if (in_array($integerid, $mapped)) $iname = "$iname\x20checked";
        echo "<character-display><div class=padding><label for=$inputname>$htmlName <input " .
                "type=checkbox value=$integerid id=$inputname name=$iname></label></div><div>" .
                "<label for=$inputname><img src=\"$img_src\" alt=\"Equip $htmlName\" $size" .
                " class=store-img loading=lazy></label></div><dl class=descLi><div data" .
                "-key=cost><dt>cost<dd>$cost</div><div data-key=id><dt>id<dd>$matches[1]" .
                "</div><div><dt>BodyName<dd>{$item['BaseBodyName']}</div></dl><div class=options>";
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
            if ($nullOption) echo "Unusable\x20" . ($i + 1); elseif ($enabled) {
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
            'colors' => $colors, 'directionName' => $directionName,
            'assetCheckoutTotal' => $assetCheckoutTotal,
            'currentlyEquipped' => $assetCheckout,
    ], JSON_INVALID_UTF8_SUBSTITUTE) ?></SCRIPT>
