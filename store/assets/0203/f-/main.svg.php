<svg><?= '<!-- Hello -->';
    global $Favicar_offsetY;

    // Base reference size these coordinates were designed for
    $refSize = 16;
    $scale = $GLOBALS['Fv_multiplySize'] / $refSize;

    // Original pixel coordinates and dimensions
    $x = (192 * $scale) + $GLOBALS['Fv_offsetX'];
    $y = (304 * $scale) + $GLOBALS['Fv_offsetY'];
    $strokeWith = $GLOBALS['Fv_multiplySize'] / 2;
    $q128 = 128 * $scale;
    $q64 = 64 * $scale;
    echo "<path d='M $x $y q $q64 $q64 $q128 0' fill='none' stroke-width='$strokeWith'/>" ?></svg>