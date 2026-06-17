<svg>
    <!--<?= 'Controls';
    $neckWidth = 50;
    $neckVWidth = 50;
    $neckHeight = 130;
    $neckHeightV = 100;
    // ---
    $topHeight = 200; // 150; // 200
    $dressWidth = 450; // 490; // 510;
    $dressWidthInverted = 800 - $dressWidth;
    $headDownward = 50;
    // ---
    $armLength = 120 * 3;
    $armLengthReturn = $armLength + 30 ?>-->
    <path d="<?= "M $dressWidth 400 L 610 1250 L 190 1250 L $dressWidthInverted 400 Z" ?>"
          fill="<?= "{$GLOBALS['colors']['pants']}" ?>"
          stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    <path d="M 530 470 l -15 <?= $topHeight ?> H 285 l -15 -<?= $topHeight ?> L 400 400 Z"
          fill="<?= "{$GLOBALS['secondary']}" ?>" stroke-width="8" stroke="#000000"/>
    <g>
        <path d="M 400 400 L 300 500 l -50 <?= $armLength ?> l -50 -10 l +40 -<?= $armLengthReturn ?> L 280 390 H 400 Z"
              fill="<?= "{$GLOBALS['colors']['skin']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
        <path d="M 400 400 L 500 500 l +50 <?= $armLength ?> l +50 -10 l -40 -<?= $armLengthReturn ?> L 520 390 H 400 Z"
              fill="<?= "{$GLOBALS['colors']['skin']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    </g>
    <g>
        <path d="M 400 400 L 300 500 l +0 +50 l -90 -10 L <?= (300 - 50 - 50 + 40) . "\x20" . (500 + $armLength - 10 - $armLengthReturn) ?> L 280 390 H 400 Z"
              fill="<?= "{$GLOBALS['colors']['body']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
        <path d="M 400 400 L 500 500 l -0 +50 l +90 -10 L <?= (500 + 50 + 50 - 40) . "\x20" . (500 + $armLength - 10 - $armLengthReturn) ?> L 520 390 H 400 Z"
              fill="<?= "{$GLOBALS['colors']['body']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
    </g>
    <g class="head">
        <path d="<?= 'M ' . (400 - $neckWidth / 2) . " 260 v $neckHeight h -$neckVWidth l " . ($neckWidth / 2 + $neckVWidth)
        . " $neckHeightV l " . ($neckWidth / 2 + $neckVWidth) . "-$neckHeightV h -$neckVWidth v -$neckHeight Z" ?>"
              fill="<?= "{$GLOBALS['skin']}" ?>" class="neck" stroke-width="8" stroke="#000000"
              stroke-linejoin="round"/>
        <ellipse rx="150" ry="100" cx="400" cy="<?= 200 + $headDownward ?>"
                 fill="<?= "{$GLOBALS['skin']}" ?>" stroke-width="8" stroke="#000000"/>
        <ellipse rx="20" ry="40" cx="350" cy="<?= 220 + $headDownward ?>"
                 fill="<?= "{$GLOBALS['eyes']}" ?>" stroke-width="8" stroke="#000000"/>
        <ellipse rx="20" ry="40" cx="450" cy="<?= 220 + $headDownward ?>"
                 fill="<?= "{$GLOBALS['eyes']}" ?>" stroke-width="8" stroke="#000000"/>
        <path d="<?= "M 520 " . (290 + $headDownward) . " l 60 -80 l -40 -100 L 400 " . (80 + $headDownward) .
        " L 280 " . (110 + $headDownward) . " l -60 80 l 40 100 l 50 -100 l 50 -50 l 40 40 l 40 -40 l 50 50 Z" ?>"
              fill="<?= "{$GLOBALS['hair']}" ?>" stroke-width="8" stroke="#000000" stroke-linejoin="round"/>
        <path d="M 368 <?= 270 + $headDownward ?> q 32 32 64 0" fill="none" class="mouth" stroke-width="8"
              stroke="#000000"/>
    </g>
</svg>