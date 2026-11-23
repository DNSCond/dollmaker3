<svg>
    <g><?= '<!-- STYLE  -->';
        if (hasOption(1)):?>
            <style>
                @keyframes wave-5004 {
                    0% {
                        transform: rotate(-90deg);
                    }
                    100% {
                        transform: rotate(360deg);
                    }
                }

                #right-arm-5004 {
                    /*animation-name: wave-5004;*/
                    animation-duration: 10000ms;
                    animation-timing-function: linear;
                    animation-iteration-count: infinite;
                }
            </style><?= "\n"; endif ?></g>
    <g>
        <path d="M 355 620 L 225 1250 h 115 L 410 620 L 470 1250 h 115 L 457 615"
              fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
        <path d="M 315 460 m -30 40 l -50 300 l +50 -30 l +50 -300" fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
        <path d="M 485 460 m +43 40 l +50 300 l -50 -30 l -50 -300" fill="<?= "{$GLOBALS['colors']['skin']}" ?>"
              id="right-arm-5004" transform-origin="500 480"/>

        <path d="M 315 460 l -40 20 l -5 50 l 270 -5 l -5 -50 l -40 -20"
              fill="<?= "{$GLOBALS['colors']['secondary']}" ?>"/>
        <path d="M 315 460 l 40 160 l 102 -5 l 40 -160 L 400 420 Z" fill="<?= "{$GLOBALS['colors']['body']}" ?>"/>
        <path d="M 380 400 l -2 33 l -17 8 l 40 70 l 50 -71 l -25 -10 l -2 -30"
              fill="<?= "{$GLOBALS['colors']['skin']}" ?>"/>
    </g>
    <path d="M 355 620 q 0 0 -150 450 Q 400 1200 595 1070 L 457 615 Z"
          fill="<?= "{$GLOBALS['colors']['pants']}" ?>"/>
</svg>