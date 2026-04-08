<?php global $dataView;
$colors = [
    'body' => '#00a8f3',
    'secondary' => '#00a8f3',
    'skin' => '#fee1b9',
    'eyes' => '#00587f',
    'pants' => '#004665',
    'shoes' => '#002d40',
    'lights' => '#fff100',
];
if ($dataView) {
    foreach (array_keys($colors) as $keyDex => $key) {
        try {
            $colors[$key] = '#' . str_pad(dechex($dataView->getColorAt($keyDex * 4)), 6, '0', STR_PAD_LEFT);
        } catch (OutOfBoundsException) {
        }
    }
}
