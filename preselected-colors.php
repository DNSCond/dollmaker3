<?php //preselectedcolors
$innerHTML = [
    'Favicond\'s outerHTML' => '#00a8f3',
    'Favicond\'s windshield' => '#8cfffa',
    'Favicond\'s Lights' => '#fff100',
    'Reddcond\'s outerHTML' => '#ff4500',
    'Reddcond\'s shades' => '#fea700',
    'skin color1' => '#fee1b9',
    'BinarybatRegular' => '#00ff00',
];
$preselectedcolors = [
    'Primary ANTRequest' => [
        'Favicond Regular' => "{$innerHTML['Favicond\'s outerHTML']}",
        'Favicond BG' => '#0073a6',
        'Favicond EYES' => '#00587f',
        'Favicond Pants' => '#004665',
        'Favicond Dark' => '#002d40',

        'Reddcond  Regular' => "{$innerHTML['Reddcond\'s outerHTML']}",
        'Reddcond  BG' => '#a62c00',
        'Reddcond  EYES' => '#7e2100',
        'Reddcond  Pants' => '#651a00',
        'Reddcond  Dark' => '#401100',

        'Buzz Regular' => "{$innerHTML['Favicond\'s Lights']}",
        'Buzz BG' => '#a68300',
        'Buzz EYES' => '#7e6400',
        'Buzz Pants' => '#655000',
        'Buzz Dark' => '#403c00',

        'Green Regular' => "{$innerHTML['BinarybatRegular']}",
        'Green BG' => '#00a600',
        'Green EYES' => '#007e00',
        'Green Pants' => '#006500',
        'Green Dark' => '#004000',

        'Magnata Regular' => '#ff00ff',
        'Magnata BG' => '#a600a6',
        'Magnata EYES' => '#7e007e',
        'Magnata Pants' => '#650065',
        'Magnata Dark' => '#400040',

        'Cian Regular' => '#00ffff',
        'Cian BG' => '#00a6a6',
        'Cian EYES' => '#007e7e',
        'Cian Pants' => '#006565',
        'Cian Dark' => '#004040',

        'Orange Regular' => '#fea700',
        'Orange BG' => '#a66d00',
        'Orange EYES' => '#7e5300',
        'Orange Pants' => '#654200',
        'Favicond\'s windshield' => '#8cfffa',
    ], 'skins' => [
        'skin color 4' => '#ffe2d3',
        'skin color 1' => '#fee1b9',
        'skin color 5' => '#bd9678',
        'skin color 2' => '#bf9765',
        'skin color 3' => '#5e462e',
        'skin color 6' => '#634c3a',
        'skin color 7' => '#593524',
    ], 'Fire and Night Light' => [
        'Fire Shoes' => '#2c2827',
        'Fire Pants' => '#d12634',
        'Fire Body' => '#fd9657',
        'Fire Secondary' => '#ffbe57',

        'Night Body' => '#191970',
        'Night Secondary' => '#a9cded',
        'Night Pants' => '#85c0fd',
        'Night Shoes' => '#85cce9'
    ],
];

function preselectedcolors(string $name, string $preselect): string
{
    $result = '';
    $checked = false;
    global $preselectedcolors;
    $preselect = colorIntToString(normalizeColor($preselect));
    $pre = "\n\n<select name=$name id=color-$name required>";
    foreach ($preselectedcolors as $outer => $colorsArray) {
        $outerName = htmlspecialchars12($outer);
        $result = "$result<optgroup label='$outerName'>";
        foreach ($colorsArray as $name => $color) {
            $color = colorIntToString(normalizeColor($color));
            $attrs = "value=$color";
            if ($color === $preselect) {
                $attrs = "$attrs\x20selected";
                $checked = true;
            }
            $result = "$result<OPTION $attrs>$name ($color)</OPTION>";
        }
        $result = "$result</OPTgroup>";
    }
    $attrs = "value='$preselect'" . (!$checked ? "\x20selected" : '');
    $result = "<optgroup label=Custom><OPTION $attrs>Custom ($preselect)</OPTION></optgroup>$result";
    return "$pre$result</select>";
}
