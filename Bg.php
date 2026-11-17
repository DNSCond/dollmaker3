<svg>
    <rect width="800" height="1280" fill="#FfFfFf"/>
    <g opacity="<?= $GLOBALS['opaque'] ? '1' : '0.7';
    global $hair, $bgcolor, $pants, $shoes ?>" stroke-width="0">
        <rect width="800" height="1280" fill="<?= "$hair" ?>" class="bgc"/>
        <path d="M 0 384 L 800 576 L 800 1280 L 0 1280 Z" fill="<?= $bgcolor ?>" class="bgc"/>
        <path d="M 0 896 L 800 1000 L 800 1280 L 0 1280 Z" fill="<?= $pants ?>" class="bgc"/>
        <path d="M 600 0 L 400 1280 L 800 1280 L 800 0 Z" fill="<?= $shoes ?>" class="bgc"/>
    </g>
    <!--<image href="/gallery/imgdata/g3vbG2_4czt.avif"/>-->
    <g fill='#ae782f'><?= (function () {
            global $pfpMode, $w, $h, $xoffset;
            $width = $pfpMode ? 10 : 20;
            $RightX = $xoffset + $w - $width;
            $DownY = $h - $width;
            return "\n" . <<<SVG
            <rect x="0" y="0" width="$width" height="1280" class="wall left"/>
            <rect x="$RightX" y="0" width="$width" height="1280" class="wall right"/>
            <rect x="0" y="$DownY" width="800" height="$width" class="wall down"/>
            <rect x="0" y="0" width="800" height="$width" class="wall up"/>
            SVG;
        })() . "\n" ?></g>
</svg>
