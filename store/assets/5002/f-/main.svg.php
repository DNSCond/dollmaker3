<svg>
    <g>
        <path d="M 355 620 L 225 1250 h 115 L 410 620 L 470 1250 h 115 L 457 615"
              fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>
        <path d="M 355 620 L 150 1250 L 650 1250 L 457 615" fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>

        <!--<?= "Rooter";
        $size = 95; // 50
        $le = 170; // 150
        $YY = 920; // 900
        $inc = 30; // 25
        $halfSize = $size / 2;
        $ri = 800 - $le ?>-->
        <path d="<?= "M $le $YY l -50 170 q +$halfSize 50 +$size $inc q +$halfSize 50 +$size $inc q +$halfSize 50 +$size $inc V +800" ?>"
              fill="<?= "{$GLOBALS['colors']['shoes']}" ?>"/>
        <path d="<?= "M $ri $YY l +50 170 q -$halfSize 50 -$size $inc q -$halfSize 50 -$size $inc q -$halfSize 50 -$size $inc V +800" ?>"
              fill="<?= "{$GLOBALS['colors']['shoes']}" ?>"/>
        <path d="<?= "M $le $YY l -50 170 q +$halfSize 50 +$size $inc q +$halfSize 50 +$size $inc q +$halfSize 50 +$size $inc" ?>"
              fill="none"/>
        <path d="<?= "M $ri $YY l +50 170 q -$halfSize 50 -$size $inc q -$halfSize 50 -$size $inc q -$halfSize 50 -$size $inc" ?>"
              fill="none"/>
        <!---->

        <path fill="<?= "{$GLOBALS['colors']['body']}" ?>"
              d="<?= "M 355 620 L 125 950 Q 400 1250 672 957 L 457 615" ?>"/>
        <path d="M 315 460 m -30 40 l -50 300 l +50 -30 l +50 -300" fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
        <path d="M 485 460 m +43 40 l +50 300 l -50 -30 l -50 -300" fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
        <path d="M 315 460 l -40 20 l -5 50 l 270 -5 l -5 -50 l -40 -20"
              fill="<?= "{$GLOBALS['colors']['secondary']}" ?>"/>
        <path d="M 315 460 l 40 160 l 102 -5 l 40 -160 L 400 420 Z" fill="<?= "{$GLOBALS['colors']['body']}" ?>"/>
        <path d="M 380 400 l -2 33 l -17 8 l 40 70 l 50 -71 l -25 -10 l -2 -30"
              fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
    </g>
</svg>