<svg>
    <g>
        <circle r="143" cx="400" cy="254" fill="<?= "{$GLOBALS['colors']['skin']}";
        ['pathStart' => $pathStart, 'pathNext' => $pathNext] = $GLOBALS['p3004'] ?>"/>
        <ellipse rx="40" ry="70" cx="345" cy="250" fill="white"/>
        <ellipse rx="40" ry="70" cx="455" cy="250" fill="white"/>
        <path d="M 345 250 m +28 50 q -50 -50 0 -100 q +25 +50 0 +100" fill="<?= "{$GLOBALS['colors']['eyes']}" ?>"/>
        <path d="M 455 250 m -28 50 q +50 -50 0 -100 q -25 +50 0 +100" fill="<?= "{$GLOBALS['colors']['eyes']}" ?>"/>
        <ellipse rx="40" ry="70" cx="345" cy="250" fill="none"/>
        <ellipse rx="40" ry="70" cx="455" cy="250" fill="none"/>
        <path stroke-width="0" fill="<?= "{$GLOBALS['colors']['hair']}" ?>" d="<?= "{$pathStart}L" . ($headPath = ' 545'
                . " 245 l -30 10 l -50 -50 l -50 5 l -15 50 l -75 -75 l -50 80 l -20 5") . ' h -5 v -100 h 20 v -20' ?>"/>
        <path d="M 368 350 q 32 32 64 0" fill="none" class="mouth"/>
        <path d="<?= "M$headPath" ?>" fill="none"/>
        <path d="<?= "$pathStart" ?>" fill="none"/>
    </g>
</svg>