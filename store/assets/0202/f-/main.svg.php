<svg>
    <g>
        <!--<?= ' draw the main body /';
        // 512 by 512 originally.
        global $xoffset;
        $offsetX = $xoffset;
        $offsetY = 0;
        $multiplySize = 16 ?>-->
        <rect fill="<?= $GLOBALS['colors']['body'] ?>" width="<?= 30 * $multiplySize ?>"
              x="<?= $multiplySize + $offsetX ?>" height="<?= 21 * $multiplySize ?>"
              y="<?= 3 * $multiplySize + $offsetY ?>"/>
        <rect fill="<?= $GLOBALS['colors']['secondary'] ?>" width="<?= 26 * $multiplySize ?>"
              x="<?= 3 * $multiplySize + $offsetX ?>" y="<?= 5 * $multiplySize + $offsetY ?>"
              height="<?= 12 * $multiplySize ?>"/>
        <!-- draw the lights /-->
        <rect fill="<?= $GLOBALS['colors']['lights'] ?>" width="<?= 4 * $multiplySize ?>"
              height="<?= 4 * $multiplySize ?>" x="<?= 24 * $multiplySize + $offsetX ?>"
              y="<?= 18 * $multiplySize + $offsetY ?>"/>
        <rect fill="<?= $GLOBALS['colors']['lights'] ?>" width="<?= 4 * $multiplySize ?>"
              x="<?= 4 * $multiplySize + $offsetX ?>" height="<?= 4 * $multiplySize ?>"
              y="<?= 18 * $multiplySize + $offsetY ?>"/>
        <!-- draw the wheels /-->
        <rect fill="<?= $GLOBALS['colors']['shoes'] ?>" width="<?= 8 * $multiplySize ?>"
              height="<?= 6 * $multiplySize ?>" x="<?= 3 * $multiplySize + $offsetX ?>"
              y="<?= 24 * $multiplySize + $offsetY ?>"/>
        <rect fill="<?= $GLOBALS['colors']['shoes'] ?>" width="<?= 8 * $multiplySize ?>"
              height="<?= 6 * $multiplySize ?>" x="<?= 21 * $multiplySize + $offsetX ?>"
              y="<?= 24 * $multiplySize + $offsetY ?>"/>
        <!-- draw the wheels /-->
        <rect fill="<?= $GLOBALS['colors']['shoes'] ?>" width="<?= 8 * $multiplySize ?>"
              height="<?= 6 * $multiplySize ?>" x="<?= 3 * $multiplySize + $offsetX ?>"
              y="<?= 24 * $multiplySize + $offsetY ?>"/>
        <rect fill="<?= $GLOBALS['colors']['shoes'] ?>" width="<?= 8 * $multiplySize ?>"
              height="<?= 6 * $multiplySize ?>" x="<?= 21 * $multiplySize + $offsetX ?>"
              y="<?= 24 * $multiplySize + $offsetY ?>"/>
    </g>
</svg>