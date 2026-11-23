<svg>
    <g stroke-width="0">
        <!--<?= ' draw the main body /';

        $x16 = function ($x) {
            return $x * $GLOBALS['Fv_multiplySize'];
        } ?>-->
        <!-- feet -->
        <rect fill="<?= $GLOBALS['colors']['shoes'] ?>" class="nega-2deg"
              x="<?= $GLOBALS['Fv_multiplySize'] * 3 + $GLOBALS['Fv_offsetX'] ?>"
              y="<?= $GLOBALS['Fv_multiplySize'] * 25 ?>" style="rotate:-2deg"
              width="<?= 23.125 * $GLOBALS['Fv_multiplySize'] ?>"
              height="<?= 3.125 * $GLOBALS['Fv_multiplySize'] ?>"
              transform-origin="<?= "{$GLOBALS['Fv_offsetX']} {$GLOBALS['Fv_offsetY']}" ?>"/>
        <!-- back-->
        <path d="<?= 'M ' . ((20 + $GLOBALS['Fv_offsetX']) * ($GLOBALS['Fv_multiplySize'] / 16)) .
        "\x20" . ((128 + $GLOBALS['Fv_offsetY']) * ($GLOBALS['Fv_multiplySize'] / 16)) . multiplyString(
                $GLOBALS['Fv_multiplySize'] / 16, " h 80 l 80 -30 l 80 301 l -150 20 ") .
        "L\x20" . ((20 + $GLOBALS['Fv_offsetX']) * ($GLOBALS['Fv_multiplySize'] / 16)) . "\x20" .
        ((410 + $GLOBALS['Fv_offsetY']) * ($GLOBALS['Fv_multiplySize'] / 16)) ?>"
              fill="<?= $GLOBALS['colors']['pants'] ?>"/>
        <!-- main body -->
        <rect fill="<?= $GLOBALS['colors']['body'] ?>" class="nega-5deg"
              x="<?= $GLOBALS['Fv_multiplySize'] * 10 + $GLOBALS['Fv_offsetX'] ?>"
              y="<?= $GLOBALS['Fv_multiplySize'] * 7 ?>" style="rotate:-5deg"
              width="<?= (310 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              height="<?= (310 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              transform-origin="<?= "{$GLOBALS['Fv_offsetX']} {$GLOBALS['Fv_offsetY']}" ?>"/>
        <rect fill="<?= $GLOBALS['colors']['secondary'] ?>" class="nega-5deg"
              x="<?= $GLOBALS['Fv_multiplySize'] * 12.5 + $GLOBALS['Fv_offsetX'] ?>"
              y="<?= $GLOBALS['Fv_multiplySize'] * 9 ?>" style="rotate:-5deg"
              width="<?= (250 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              height="<?= (105 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              transform-origin="<?= "{$GLOBALS['Fv_offsetX']} {$GLOBALS['Fv_offsetY']}" ?>"/>
        <rect fill="<?= "{$GLOBALS['colors']['lights']}" ?>" class="nega-5deg"
              x="<?= $GLOBALS['Fv_multiplySize'] * 13 + $GLOBALS['Fv_offsetX'] ?>"
              y="<?= $GLOBALS['Fv_multiplySize'] * 17 ?>" style="rotate:-5deg"
              width="<?= (100 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              height="<?= (45 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              transform-origin="<?= "{$GLOBALS['Fv_offsetX']} {$GLOBALS['Fv_offsetY']}" ?>"/>
        <rect fill="<?= "{$GLOBALS['colors']['lights']}" ?>" class="nega-5deg"
              x="<?= $GLOBALS['Fv_multiplySize'] * 23 + $GLOBALS['Fv_offsetX'] ?>"
              y="<?= $GLOBALS['Fv_multiplySize'] * 17 ?>" style="rotate:-5deg"
              width="<?= (80 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              height="<?= (45 / 16) * $GLOBALS['Fv_multiplySize'] ?>"
              transform-origin="<?= "{$GLOBALS['Fv_offsetX']} {$GLOBALS['Fv_offsetY']}" ?>"/>
    </g>
</svg>