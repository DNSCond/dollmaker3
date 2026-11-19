<svg>
    <g>
        <path d="<?= ($pathStart = "M 250 150 q 100 -80 270 -70 l -30 50 q 50 15 100 50 l -30 50 l 50 15 ") .
        ($pathNext = " l -75 100 l 50 5 q -75 75 -75 200 l 75 -35 q -50 100 -50 200 l 50 -50 q -50 100 -50 200 L 235".
        " 815 q -75 20 -150 100 q 0 -100 100 -200 l -50 5 q 0 -100 100 -200 l -75 5 q 0 -100 50 -200 l -50 5 Z");
        $GLOBALS['p3004'] = ['pathStart' => $pathStart, '$pathNext' => $pathNext] ?>"
              fill="<?= "{$GLOBALS['colors']['hair']}" ?>" stroke-width="0"/>
        <path d="<?= "$pathStart$pathNext" ?>" fill="none"/>
    </g>
</svg>