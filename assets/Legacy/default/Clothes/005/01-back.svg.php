<g data-name="<?= Helpers\htmlspecialchars12(($json = json_decode(file_get_contents(__DIR__ . '/metadata.json'), true))['name']);
global $eyes, $bgcolor, $pants, $shoes, $fgcolor, $skin, $arms, $hair, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
global $opacity, $stroke;
$down = 425;
$down += 30 ?>">
    <path fill="<?= $lights ?>" d="<?= "M 400 $down l -350 -100 v 200 l +350 100" ?>"
          stroke-width="8" stroke="#000000"/>
    <path fill="<?= $lights ?>" d="<?= "M 400 $down l +350 -100 v 200 l -350 100" ?>"
          stroke-width="8" stroke="#000000"/>
</g>
