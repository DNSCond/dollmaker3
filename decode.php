<?php use function ANTHeader\ANTNavBinary;
use function ANTHeader\create_head2;
use function ANTHeader\ANTNavHome;
use ANTHeader\ANTNavLinkTag;
use ANTHeader\ANTNavOption;
use ANTHeader\ANTNavIStyle;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/createHead2.php";

$bgcolor = new Color('#0073a6');
create_head2('Decoder Table!', [], [
    new ANTNavIStyle('table{border-collapse:collapse;background-color:white;margin:auto;}td,th{border' .
        ': 1px solid #dddddd;text-align:left;padding:8px;}tr:nth-child(even){background-color:#dddddd;}'),
], [
    ANTNavHome(),
    ANTNavBinary('/dollmaker3/decode.php', 'Decoder Table!', true),
]);
echo '<table><thead><tr><th>index<th>byte hexcode<th>byte decimal<th>type</thead><tbody>';
require_once 'preprocessor.php';
global $canonicalized;
$i = 0;
$c = 1;
$matched = [
    'Color Alpha ' . $c, 'Color Blue ' . $c, 'Color Green ' . $c, 'Color Red ' . $c++,
    'Color Alpha ' . $c, 'Color Blue ' . $c, 'Color Green ' . $c, 'Color Red ' . $c++,
    'Color Alpha ' . $c, 'Color Blue ' . $c, 'Color Green ' . $c, 'Color Red ' . $c++,
    'Color Alpha ' . $c, 'Color Blue ' . $c, 'Color Green ' . $c, 'Color Red ' . $c++,
    'Color Alpha ' . $c, 'Color Blue ' . $c, 'Color Green ' . $c, 'Color Red ' . $c++,
    'Color Alpha ' . $c, 'Color Blue ' . $c, 'Color Green ' . $c, 'Color Red ' . $c++,
    'Color Alpha ' . $c, 'Color Blue ' . $c, 'Color Green ' . $c, 'Color Red ' . $c++,

    'Global Options', 'Asset Count',
    // assets
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',
    'Asset Id Le Begin (uint16)', 'Asset Id Le End (uint16)', 'Asset Options',

];// print('\'Asset Id Le Begin (uint16)\', \'Asset Id Le End (uint16)\', \'Asset Options\',\n' * 50)
$i--;
foreach ($canonicalized->asArray() as $item) {
    echo "\n<tr><td>" . (++$i) . "<td>" . dechex($item) . "<td>$item<td>" . ($matched[$i] ?? 'Unknwon');
}
echo "</table>\n";
