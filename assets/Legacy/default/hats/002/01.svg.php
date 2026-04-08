<g data-name="<?= Helpers\htmlspecialchars12(($json = json_decode(file_get_contents(__DIR__ . '/metadata.json'), true))['name']);
global $eyes, $bgcolor, $pants, $shoes, $fgcolor, $skin, $arms, $hair, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
global $opacity, $stroke;
($D = ($bowSizeH = 30) * 2);
($bowSizeW = 40) ?>">
    <path d="<?= "M 540 110 m -20 40 l $bowSizeW $bowSizeH v -$D l -$bowSizeW $bowSizeH l -$bowSizeW $bowSizeH v -$D Z" ?>"
          fill="#f5749d" transform="rotate(20)" transform-origin="540 110" stroke-width="8" stroke="#000000"/>
</g>