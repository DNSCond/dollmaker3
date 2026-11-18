<svg><?= '<g>';
    global $Favicar_offsetX, $Favicar_offsetY, $Favicar_multiplySize;

    $l32 = $Favicar_multiplySize * 2;
    $l48 = $Favicar_multiplySize * 3;
    $earY = $Favicar_multiplySize * 3 + $Favicar_offsetY;
    $earLeftX = $Favicar_multiplySize * 4 + $Favicar_offsetX;
    $earRighX = $Favicar_multiplySize * 24 + $Favicar_offsetX;
    echo "<path d='M $earLeftX $earY l $l32 -$l48 l $l32 $l48' fill='{$GLOBALS['colors']['body']}'/>";
    echo "<path d='M $earRighX $earY l $l32 -$l48 l $l32 $l48' fill='{$GLOBALS['colors']['body']}'/>";
    echo "</g>" ?></svg>