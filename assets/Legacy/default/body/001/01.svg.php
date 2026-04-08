<g data-name="<?= Helpers\htmlspecialchars12(($json = json_decode(file_get_contents(__DIR__ . '/metadata.json'), true))['name']);
global $eyes, $bgcolor, $pants, $shoes, $fgcolor, $skin, $arms, $hair, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
global $opacity, $stroke ?>">
    <g class="head">
        <path d="M 350 260 v 130 l 50 50 l 50 -50 v -130 Z" fill="<?= $skin ?>" class="neck" stroke-width="8"
              stroke="#000000"/>
        <ellipse rx="150" ry="100" cx="400" cy="200" fill="<?= $skin ?>" stroke-width="8" stroke="#000000"/>
        <ellipse rx="20" ry="40" cx="350" cy="220" fill="<?= "$eyes" ?>" stroke-width="8" stroke="#000000"/>
        <ellipse rx="20" ry="40" cx="450" cy="220" fill="<?= "$eyes" ?>" stroke-width="8" stroke="#000000"/>
        <path d="M 520 290 l 60 -80 l -40 -100 L 400 80 L 280 110 l -60 80 l 40 100 l 50 -100 l 50 -50 l 40 40 l 40 -40 l 50 50 Z"
              fill="<?= "$hair" ?>" stroke-width="8" stroke="#000000"/>
        <path d="M 368 270 q 32 32 64 0" fill="none" class="mouth" stroke-width="8" stroke="#000000"/>
    </g>
    <g class="dressPatterns"><?php // = $backString ?></g>
    <path d="M 270 350 h 260 l 100 100 l -100 400 l -50 -50 L 530 450 L 270 450 l 50 350 l -50 50 L 170 450 Z"
          fill="<?= $arms ?>" class="arms" stroke-width="8" stroke="#000000"/>
    <path d="M 170 450 m -10 -50 L 305 420 L 350 400 L 400 425 L 450 400 L 495 420 L 640 400 l 20 100 L 500 500 L 640 1260 H 160 L 300 500 L 140 500 Z"
          fill="<?= $bgcolor ?>" stroke-width="8" stroke="#000000"
          class="mainframe"<?php // = $hideLegs ? ' opacity="0"' : '' ?>/>
    <g class="dressPatterns"><?php // = "$hatString$dressString\n" ?></g>
</g>