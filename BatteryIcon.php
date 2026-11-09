<?php header('No-Vary-Search: key-order, params, except=("fill" "powercolor")');
header('cache-control: max-age=' . (60 * 60) . ', immutable');
header('content-type: image/svg+xml') ?>
<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
    <rect width="<?= 32 + (32 / 2) ?>" height="<?= $height = 24 ?>" x="4" y="<?= 32 - ($height / 2) ?>" fill="#808080"/>
    <rect width="<?= 4 ?>" height="<?= $height / 1.5 ?>" x="<?= 4 + (32 + (32 / 2)) ?>"
          y="<?= 32 - ($height / 3) ?>" fill="#ff69b4"/>
    <rect width="<?= min($percent = +(preg_match('/^\\d{1,3}$/D', $_GET['fill']) ? $_GET['fill'] : 72) / 100, 1) * (32 + (32 / 2)) ?>"
          height="<?= $height ?>" x="4" y="<?= 32 - ($height / 2) ?>" fill="<?= (function ($percent) {
        if (array_key_exists('powercolor', $_GET)) {
            $percent = min($percent, 1) * 100;
            if ($percent < 25) return '#dc2626';
            elseif ($percent < 60) return '#facc15';
            else return '#22c55e';
        } else return '#e689bf';
    })($percent) ?>"/>
</svg>
