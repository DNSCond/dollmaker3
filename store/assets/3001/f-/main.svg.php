<svg>
    <g stroke-width="8" stroke="#000000" stroke-linejoin="round">
        <path d="M 355 620 L 225 1250 h 115 L 410 620 L 470 1250 h 115 L 457 615"
              fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>
        <g fill="none" opacity="<?= (int)hasOption(2) ?>">
            <!-- draw proper pants -->
        </g>
        <g fill="none" opacity="<?= (int)!hasOption(2) ?>">
            <path fill="<?= "{$GLOBALS['colors']['body']}" ?>" d="<?= "M 355 620 L 125 950 " . (!hasOption(1)
                    ? "q 5 90 65 67 q 5 80 95 30 q 80 160 222 45 q 89 30 105 -75 q 100 60 60 -60"
                    : 'Q 400 1250 672 957') . " L 457 615" ?>"/>

            <path d="<?= "M 125 950 m 25 -30 Q 450 1130 605 850 L 672 957 Q 400 1250 125 950 Z" ?>"
                  fill="<?= "{$GLOBALS['colors']['secondary']}" ?>" opacity="<?= (int)hasOption(1) ?>"/>
            <g fill="none" opacity="<?= (int)!hasOption(1) ?>">
                <path d="M 355 620 L 125 950 q 5 90 65 67 q 5 80 95 30 q 80 160 222 45 q 89 30 105 -75 L 470 705"/>
                <path d="M 355 620 L 125 950 q 5 90 65 67 q 5 80 95 30 q 80 160 222 45 L 430 700"/>
                <path d="M 355 620 L 125 950 q 5 90 65 67 q 5 80 95 30 L 390 690"/>
                <path d="M 355 620 L 125 950 q 5 90 65 67 L 345 700"/>
            </g>
        </g>
        <path d="M 315 460 m -30 40 l -50 300 l +50 -30 l +50 -300" fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
        <path d="M 485 460 m +30 40 l +50 300 l -50 -30 l -50 -300" fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
        <path d="M 315 460 l -40 20 l -5 50 l 270 -5 l -5 -50 l -40 -20"
              fill="<?= "{$GLOBALS['colors']['secondary']}" ?>"/>
        <path d="M 315 460 l 40 160 l 102 -5 l 40 -160 L 400 420 Z" fill="<?= "{$GLOBALS['colors']['body']}" ?>"/>
        <path d="M 380 400 l -2 33 l -17 8 l 40 70 l 50 -71 l -25 -10 l -2 -30" fill="<?= "{$GLOBALS['skin']}" ?>"/>
    </g>
</svg>