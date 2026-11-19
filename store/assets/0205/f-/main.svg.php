<svg><?= '<g stroke-width="0">';
    global $Favicar_offsetX, $Favicar_offsetY, $Favicar_multiplySize;
    $fill = "{$GLOBALS['colors']['lights']}";
    $w128 = $Favicar_multiplySize * 8;
    $x128 = $w128 + $Favicar_offsetX;
    $h32 = $Favicar_multiplySize * 2;
    $x256 = $Favicar_multiplySize * 16 + $Favicar_offsetX;
    $y16 = $Favicar_multiplySize + $Favicar_offsetY;
    echo "<rect x='$x128' width='$w128' height='$h32' y='$y16' fill='$fill'/><rect"
            . " x='$x256' width='$w128' height='$h32' y='$y16' fill='$fill'/></g>" ?></svg>