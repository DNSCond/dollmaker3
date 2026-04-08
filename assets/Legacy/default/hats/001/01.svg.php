<g data-name="<?= Helpers\htmlspecialchars12(($json = json_decode(file_get_contents(__DIR__ . '/metadata.json'), true))['name']);
global $eyes, $bgcolor, $pants, $shoes, $fgcolor, $skin, $arms, $hair, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
global $opacity, $stroke ?>">
    <path d="M 280 140 l +30 -80 l +30 60" fill="<?= $hair ?>" stroke-width="8" stroke="#000000"/>
    <path d="M 520 140 l -30 -80 l -30 60" fill="<?= $hair ?>" stroke-width="8" stroke="#000000"/>
</g>