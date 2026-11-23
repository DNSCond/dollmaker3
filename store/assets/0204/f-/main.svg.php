<svg><?= '<g stroke-width="0">';

    $l32 = $GLOBALS['Fv_multiplySize'] * 2;
    $l48 = $GLOBALS['Fv_multiplySize'] * 3;
    $earY = $GLOBALS['Fv_multiplySize'] * 3 + $GLOBALS['Fv_offsetY'];
    $earLeftX = $GLOBALS['Fv_multiplySize'] * 4 + $GLOBALS['Fv_offsetX'];
    $earRighX = $GLOBALS['Fv_multiplySize'] * 24 + $GLOBALS['Fv_offsetX'];
    echo "<path d='M $earLeftX $earY l $l32 -$l48 l $l32 $l48' fill='{$GLOBALS['colors']['body']}'/>";
    echo "<path d='M $earRighX $earY l $l32 -$l48 l $l32 $l48' fill='{$GLOBALS['colors']['body']}'/>";
    echo "</g>" ?></svg>