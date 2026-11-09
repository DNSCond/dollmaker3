<svg>
    <rect fill="<?= "{$GLOBALS['colors']['pants']}";
    $qY = 50 ?>" x="300" y="550" width="200" height="230"
          stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    <!---->
    <path d="<?= "M 300 570 L 300 700 q -150 +$qY -200 +550 H 410 V 570" ?>"
          fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>
    <path d="<?= "M 500 570 L 500 700 q +150 +$qY +200 +550 H 390 V 570" ?>"
          fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>
    <!---->
    <path d="<?= "M 250 +730 Q 380 950 660 1000 Q 685 1100 700 1250 L 100 1250 q +50 -500 +200 -550" ?>"
          fill="<?= "{$GLOBALS['colors']['shoes']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    <!---->
    <path d="<?= "M 300 570 L 300 700 q -150 +$qY -200 +550 H 400" ?>"
          fill="transparent" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    <path d="<?= "M 500 570 L 500 700 q +150 +$qY +200 +550 H 400" ?>"
          fill="transparent" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    <g opacity="<?= 0 /*$GLOBALS['options'][1]*/ ?>">
        <path d="<?= 'M 300 700 q -110 +50 -150 +200 l +200 +70 l +50 -200 q -27 -50 -100 -70' ?>"
              fill="<?= "{$GLOBALS['colors']['pants']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
        <path d="<?= 'M 500 700 q +110 +50 +150 +200 l -200 +70 l -50 -200 q +27 -50 +100 -70' ?>"
              fill="<?= "{$GLOBALS['colors']['pants']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    </g>
</svg>