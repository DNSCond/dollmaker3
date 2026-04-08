<g data-name="<?= Helpers\htmlspecialchars12(($json = json_decode(file_get_contents(__DIR__ . '/metadata.json'), true))['name']);
global $eyes, $bgcolor, $pants, $shoes, $fgcolor, $skin, $arms, $hair, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
global $opacity, $stroke ?>">
    <path d="M 433 1100.57876 Q 300 1260 160 1260 L 200 1050 L 283.25 986.624"
          fill="<?= $shoes ?>" stroke-width="8" stroke="#000000"/>
    <path d="M 350 1045 q -50 75 -170 120 L 200 1050 L 283.25 986.624"
          fill="<?= $pants ?>" stroke-width="8" stroke="#000000"/>
    <path d="M 283.25 986.624 Q 450 1150 620 1150 L575 912.5 Q 475 887.5 425 812.5"
          fill="<?= $shoes ?>" stroke-width="8" stroke="#000000"/>
    <path d="M 353 916.5 q 100 100 248.3 130 L 575 912.5 Q 475 887.5 425 812.5"
          fill="<?= $pants ?>" stroke-width="8" stroke="#000000"/>
    <path d="M 500 500 Q 500 850 200 1050 L 300 500 Q 400 530 500 500"
          fill="<?= $bgcolor ?>" stroke-width="8" stroke="#000000"/>
</g>