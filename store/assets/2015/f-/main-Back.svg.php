<svg>
    <g>
        <rect fill="<?= "{$GLOBALS['colors']['pants']}";
        $lowerAmount = (hasOption(1) ? 30 : 0);
        $lowerAmountHalf = $lowerAmount / 2;
        $y = hasOption(2) ? 1225 : 1250;
        $y900 = 900 + $lowerAmountHalf ?>" x="300" y="550" width="200" height="300"/>
        <!---->
        <path d="<?= "M 150 900 L 100 $y L 270 1250 H 530 L 700 $y L 650 900 Z" ?>"
              fill="<?= "{$GLOBALS['colors']['lights']}" ?>"/>
        <!---->
        <path d="<?= "M 150 $y900 l -50 170 q +50 50 +100 0 q +50 50 +100 0 q +50 50 +100 0 V +800" ?>"
              fill="<?= "{$GLOBALS['colors']['shoes']}" ?>"/>
        <path d="<?= "M 650 $y900 l +50 170 q -50 50 -100 0 q -50 50 -100 0 q -50 50 -100 0 V +800";
        $lowered = 770 + $lowerAmount ?>" fill="<?= "{$GLOBALS['colors']['shoes']}" ?>"/>
        <!---->
        <path d="<?= "M 370 $lowered L 270 1250 H 530 L 430 $lowered Z" ?>" fill="<?= "#ffFFff" ?>"/>
        <!---->
        <path d="<?= (function () use ($lowerAmount, $lowered) {
            $start = 700 + $lowerAmount;
            $loweredDeep = 950 + $lowerAmount;
            return "M 300 $start q -180 +50 -200 +275 Q 350 $loweredDeep 400 $lowered q -67 -5 -100 -70";
        })() ?>" fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>
        <path d="<?= (function () use ($lowerAmount, $lowered) {
            $start = 700 + $lowerAmount;
            $loweredDeep = 950 + $lowerAmount;
            return "M 500 $start q +180 +50 +200 +275 Q 450 $loweredDeep 400 $lowered q +67 -5 +100 -70";
        })() ?>" fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>
    </g>
</svg>
