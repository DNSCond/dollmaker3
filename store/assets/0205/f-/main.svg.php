<svg><?= '<g stroke-width="0">';
    $fill = "{$GLOBALS['colors']['lights']}";
    $w128 = $GLOBALS['Fv_multiplySize'] * 8;
    $x128 = $w128 + $GLOBALS['Fv_offsetX'];
    $h32 = $GLOBALS['Fv_multiplySize'] * 2;
    $x256 = $GLOBALS['Fv_multiplySize'] * 16 + $GLOBALS['Fv_offsetX'];
    $y16 = $GLOBALS['Fv_multiplySize'] + $GLOBALS['Fv_offsetY'];
    echo "<rect x='$x128' width='$w128' height='$h32' y='$y16' fill='$fill'/><rect"
            . " x='$x256' width='$w128' height='$h32' y='$y16' fill='$fill'/></g>" ?></svg>