<svg><?= '<g>';
    global $Favicar_offsetX, $Favicar_offsetY, $Favicar_multiplySize;

    // Base reference size these coordinates were designed for
    $refSize = 16;
    $scale = $Favicar_multiplySize / $refSize;

    // Original pixel coordinates and dimensions
    $x = (192 * $scale) + $Favicar_offsetX;
    $y = (304 * $scale) + $Favicar_offsetY;
    $strokeWith = $Favicar_multiplySize / 2;
    $q128 = 128 * $scale;
    $q64 = 64 * $scale;
    echo "<path d='M $x $y q $q64 $q64 $q128 0' fill='none' stroke='black' stroke-width='$strokeWith'/>";
    echo '</g>' ?></svg>