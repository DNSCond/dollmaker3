<svg>
    <g stroke-width="0">
        <!--<?= ' draw the main body /';

        global $Favicar_offsetX, $Favicar_offsetY, $Favicar_multiplySize;
        $x16 = function ($x) use ($Favicar_multiplySize) {
            return $x * $Favicar_multiplySize;
        } ?>-->
        <!-- feet -->
        <rect fill="<?= $GLOBALS['colors']['shoes'] ?>"
              x="<?= $Favicar_multiplySize * 3 + $Favicar_offsetX ?>"
              y="<?= $Favicar_multiplySize * 25 ?>" style="rotate:-2deg"
              width="<?= 23.125 * $Favicar_multiplySize ?>"
              height="<?= 3.125 * $Favicar_multiplySize ?>"
              transform-origin="<?= "$Favicar_offsetX $Favicar_offsetY" ?>"/>
        <!-- back-->
        <path d="<?= 'M ' . ((20 + $Favicar_offsetX) * ($Favicar_multiplySize / 16)) .
        "\x20" . ((128 + $Favicar_offsetY) * ($Favicar_multiplySize / 16)) . multiplyString(
                $Favicar_multiplySize / 16, " h 80 l 80 -30 l 80 301 l -150 20 ") .
        "L\x20" . ((20 + $Favicar_offsetX) * ($Favicar_multiplySize / 16)) .
        "\x20" . ((410 + $Favicar_offsetY) * ($Favicar_multiplySize / 16)) ?>"
              fill="<?= $GLOBALS['colors']['pants'] ?>"/>
        <!-- main body -->
        <rect fill="<?= $GLOBALS['colors']['body'] ?>"
              x="<?= $Favicar_multiplySize * 10 + $Favicar_offsetX ?>"
              y="<?= $Favicar_multiplySize * 7 ?>" style="rotate:-5deg"
              width="<?= (310 / 16) * $Favicar_multiplySize ?>"
              height="<?= (310 / 16) * $Favicar_multiplySize ?>"
              transform-origin="<?= "$Favicar_offsetX $Favicar_offsetY" ?>"/>
        <rect fill="<?= $GLOBALS['colors']['secondary'] ?>"
              x="<?= $Favicar_multiplySize * 12.5 + $Favicar_offsetX ?>"
              y="<?= $Favicar_multiplySize * 9 ?>" style="rotate:-5deg"
              width="<?= (250 / 16) * $Favicar_multiplySize ?>"
              height="<?= (105 / 16) * $Favicar_multiplySize ?>"
              transform-origin="<?= "$Favicar_offsetX $Favicar_offsetY" ?>"/>
        <rect fill="<?= "{$GLOBALS['colors']['lights']}" ?>"
              x="<?= $Favicar_multiplySize * 13 + $Favicar_offsetX ?>"
              y="<?= $Favicar_multiplySize * 17 ?>" style="rotate:-5deg"
              width="<?= (100 / 16) * $Favicar_multiplySize ?>"
              height="<?= (45 / 16) * $Favicar_multiplySize ?>"
              transform-origin="<?= "$Favicar_offsetX $Favicar_offsetY" ?>"/>
        <rect fill="<?= "{$GLOBALS['colors']['lights']}" ?>"
              x="<?= $Favicar_multiplySize * 23 + $Favicar_offsetX ?>"
              y="<?= $Favicar_multiplySize * 17 ?>" style="rotate:-5deg"
              width="<?= (80 / 16) * $Favicar_multiplySize ?>"
              height="<?= (45 / 16) * $Favicar_multiplySize ?>"
              transform-origin="<?= "$Favicar_offsetX $Favicar_offsetY" ?>"/>
    </g>
</svg>