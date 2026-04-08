<g data-name="<?= Helpers\htmlspecialchars12(($json = json_decode(file_get_contents(__DIR__ . '/metadata.json'), true))['name']);
global $eyes, $bgcolor, $pants, $shoes, $fgcolor, $skin, $arms, $hair, $backgroundColor, $sleeves, $lights, $wheels, $secondary;
global $opacity, $stroke ?>">
    <path d="<?= new PathSVG(375 + 2, 196 + 2)
            ->relativeQuadraticBezierCurve(5, 60, -13, 68)
            ->relativeLineTo(0, 70)
            ->relativeLineTo(70, 0)
            ->absoluteLineTo(438, 250 - 9)
            ->relativeQuadraticBezierCurve(-2, -25 / 2, 7, -25) ?>"
          fill="<?= $skin ?>" opacity="<?= $opacity ?>"
          stroke-width="<?= $stroke ?>" stroke="#000000" class="face"/>
    <path d="<?= new PathSVG(375 + 1, 196 - 1)
            ->rotationalLineTo(+140, 50)
            ->rotationalLineTo(-74, 50)
            ->rotationalLineTo(-37, 50)
            ->rotationalLineTo(-20, 70)
            ->rotationalLineTo(-90, 140)
            ->closePath() ?>" fill="<?= $skin ?>" opacity="<?= $opacity ?>"
          stroke-width="<?= $stroke ?>" stroke="#000000" class="face"/>
    <path d="<?= new PathSVG(352, 67)
            ->relativeQuadraticBezierCurve(-15, 15, -60, 16)
            ->relativeQuadraticBezierCurve(15 * 0.8, 15 * 0.5, 60 * 0.8, (16 * 0.7) - 2)
            ->relativeQuadraticBezierCurve(-10, 15, -(45 + 1), 26 + 1)
            ->relativeQuadraticBezierCurve(50 / 2, 2, 43, 0.3)
            ->rotationalLineTo(180 + 45 + 5, 35, true)
            ->rotationalLineTo(180 + 11, 30)
            ->relativeQuadraticBezierCurve(-18, 28, -28, 32)
            ->relativeQuadraticBezierCurve(18, 1, (18 * 2) - 2, -9)
            ->snapToIntegerGrid('L', false, true)
            ->relativeQuadraticBezierCurve(-3, 18, -15, 35)
            ->relativeQuadraticBezierCurve(10, -5, 23, -17)
            ->relativeQuadraticBezierCurve(7, 35 / 2, -4, 36)
            ->relativeQuadraticBezierCurve(5, 0, 13, -16)
            ->relativeQuadraticBezierCurve(0, 12, -10, 18)
            ->relativeQuadraticBezierCurve(18 / 2, -1, 17.5, -12)
            ->relativeVertical(15)
            ->relativeQuadraticBezierCurve(0, 4, -7, 7)
            ->relativeQuadraticBezierCurve(0, 4, 13, -7)
            ->relativeLineTo(5, 17)
            // inner
            ->relativeLineTo(-5, -75)
            ->relativeLineTo(+5, -25)
            ->absoluteLineTo(478, 117)
            ->absoluteLineTo(478 - 2, 117 + 50)
            // resume
            ->absoluteLineTo(445 - 2, 225)
            ->relativeLineTo(3, 3)
            ->relativeQuadraticBezierCurve(1, -7, 4, -10)
            ->relativeLineTo(0, 10)
            ->relativeQuadraticBezierCurve(2, -(15 / 2), 8, -15)
            ->relativeQuadraticBezierCurve(2, (15 / 2), 7, 13)
            ->relativeQuadraticBezierCurve(-5, -(12 / 2), -2, -12)
            ->relativeQuadraticBezierCurve(5, -(20 * 0.5), 19, -20)
            ->relativeQuadraticBezierCurve(-2, 4, 7, 22)
            ->relativeQuadraticBezierCurve(-4, -10, 12, -45)
            ->relativeQuadraticBezierCurve(5, 27 / 2, 2, 27)
            ->relativeQuadraticBezierCurve(5, -5, 3.5, -((27 / 2)) - 3.5)
            ->relativeLineTo(15, 15)
            ->relativeQuadraticBezierCurve(-10, -10, -8, -40)
            ->relativeQuadraticBezierCurve(7, 17, 20, 17)
            ->absoluteQuadraticBezierCurve(512.5 + 10, 144 + 30, 512.5, 144)
            ->relativeQuadraticBezierCurve(10, 16, 30 - 2, 22)
            ->relativeQuadraticBezierCurve(-20, -(35 / 2), -22, -35)
            ->relativeQuadraticBezierCurve(5, 5, 26, 14)
            ->relativeQuadraticBezierCurve(-(27 / 2) - 7, -(36 / 2) + 5, -27, -36)
            ->relativeQuadraticBezierCurve(15, 7, 37, 7)
            ->relativeQuadraticBezierCurve(-30, -6, -46, -33)
            ->relativeQuadraticBezierCurve(30 / 2, 23 * 0.2, 30, 23)
            ->absoluteQuadraticBezierCurve(493.5 + 30, 68 + 10, 493.5, 68)
            ->relativeQuadraticBezierCurve((30 / 2) + 2, (23 * -0.2) + 2, 33, -32)
            ->relativeQuadraticBezierCurve(-37 / 2, 18, -37, 19)
            ->relativeLineTo(3, -7)
            ->relativeQuadraticBezierCurve(-5, 10, -10, 11)
            ->relativeQuadraticBezierCurve(10, -20, -30, -50)
            ->relativeQuadraticBezierCurve((17 / 2) + 8, (41 / 2) - 5, 17, 41)
            ->relativeQuadraticBezierCurve(-5, -(26 / 2), -23, -26)
            ->relativeQuadraticBezierCurve(7, (15 / 2), 10, 15)
            ->relativeQuadraticBezierCurve(-32, -19.5, -64, -19.5)
            ->relativeQuadraticBezierCurve(30, 8, 38, 19)
            ->relativeQuadraticBezierCurve(-50, -7, -64 * 1.45, 13)
            ->relativeQuadraticBezierCurve(20, -10, 40, -3)
            ->relativeQuadraticBezierCurve(-52 / 2, 5, -52.5, 28)
            ->absoluteQuadraticBezierCurve(352 - 10, 67 - 2, 352, 67)
            ->closePath() ?>" fill="<?= $hair ?>" stroke-width="<?= $stroke ?>"
          stroke="#000000" opacity="<?= $opacity ?>" class="hair"/>
    <g fill="transparent" stroke-width="<?= $stroke ?>"
       stroke="#000000" data-name="swappable.eyes">
        <g opacity="<?= $opacity ?>">
            <path d="<?= new PathSVG(400, 195)->relativeQuadraticBezierCurve(20, 15, 40, 10) ?>" class="mouth"/>
            <path d="<?= new PathSVG(410, 150)
                    ->relativeQuadraticBezierCurve(-10, -15, -30, -10)
                    ->absoluteLineTo(382, 153)->relativeLineTo(6, 6)
                    ->rotationalLineTo(-35, 20) ?>" fill="#ffffff" class="eye left"/>
            <path d="<?= new PathSVG(445, 161)
                    ->relativeQuadraticBezierCurve(15, -10, 26.5, 7.5)
                    ->relativeQuadraticBezierCurve(0, 2, -10, 10)->
                    relativeQuadraticBezierCurve(0, 0, -17, -6) ?>" class="eye right"
                  stroke-width="<?= $stroke ?>" stroke="#000000" fill="#ffffff"/>
            <path d="<?= new PathSVG(446, 166)
                    ->relativeQuadraticBezierCurve(0, 4, 2, 7.6)
                    ->relativeLineTo(7, 2.7)
                    ->relativeQuadraticBezierCurve(4, -7.6 * 0.3, 6.5, -7.6)
                    ->relativeQuadraticBezierCurve(3, -7, -3, -11)
                    ->relativeLineTo(-7, 1)
                    ->absoluteQuadraticBezierCurve(446, 166 - 7, 446, 166)
                    ->closePath() ?>" class="eye right"
                  fill="<?= $hair ?>"/>
            <path d="<?= new PathSVG(410, 150)
                    ->relativeQuadraticBezierCurve(-10, -15, -30, -10) ?>"
                  class="eye irish left" stroke-width="<?= $stroke * 3 ?>" fill="transparent"/>
            <path d="<?= new PathSVG(445, 161)->relativeQuadraticBezierCurve(15, -10, 26.5, 7.5) ?>"
                  class="eye irish right" stroke-width="<?= $stroke * 3 ?>" fill="transparent"/>
            <path d="<?= new PathSVG(445 + (26 / 2) - 3.5, 162.5)
                    ->relativeQuadraticBezierCurve(3, 2, 2, 5)
                    ->relativeQuadraticBezierCurve(-2, 3, -5, 2)
                    ->relativeQuadraticBezierCurve(-1.2, -1.3, -1, -3.5)
                    ->relativeQuadraticBezierCurve(1, -4, 4, -3.5)->closePath() ?>"
                  class="eye pupil right" stroke-width="0" fill="#000000"/>
        </g>
    </g>
    <path d="<?= new PathSVG(378.5, 225)->relativeQuadraticBezierCurve(-50 / 2, 0, -50, 14)
            ->relativeLineTo(8, 22)->rotationalLineTo(0, 12)
            ->relativeQuadraticBezierCurve(-35, 12, -40, 12)
            ->relativeQuadraticBezierCurve(-25 / 2, 1, -25, 5)
            ->relativeQuadraticBezierCurve(-10, 2, -10 - 3, 20 - 2)
            ->relativeQuadraticBezierCurve(-5, 35 / 2, -12, 35)
            ->relativeQuadraticBezierCurve(-1, 5, -5, 7)
            ->relativeQuadraticBezierCurve(-5, 0, -5, 7)
            ->relativeQuadraticBezierCurve(0, 13, -12, 23)
            ->relativeQuadraticBezierCurve(10, -((60 + 2) / 2), 10, -60 + 2)
            ->relativeLineTo(-0.5, -5)
            ->absoluteCubicBezierCurve(
                    200 + (+78 * 0.4), 318 - 21,
                    200 + (-78 * 0.4), 318 - 21,
                    161, 318)
            ->relativeLineTo(2, 156)
            ->relativeCubicBezierCurve(5, 8, 17, 17, 25, 21)
            ->relativeQuadraticBezierCurve(20, -6, 40, -18)
            ->relativeQuadraticBezierCurve(66 * 0.3 + 3, -59 * 0.3, 66, -59)
            ->relativeQuadraticBezierCurve(12, 65, -4, 88)
            ->relativeLineTo(1.5, 10)->relativeLineTo(-9, 7)
            ->relativeCubicBezierCurve(0, 25, -20, 35, -50 + 2, 100 - 6)
            ->relativeQuadraticBezierCurve((23 / 2), (19 / 2) + 5, 23, 19)
            // Rightside
            ->absoluteLineTo(482, 566)
            ->relativeQuadraticBezierCurve(-5, -12, -13, -14)
            ->relativeVertical(-15)->relativeLineTo(-8, -12)
            ->relativeLineTo(7, -11)
            ->relativeQuadraticBezierCurve(-10, -13, 14, -50)
            ->absoluteLineTo(506, 420 - 1)->relativeLineTo(7, 20)
            ->rotationalLineTo(-1.3, 30)
            ->absoluteQuadraticBezierCurve(523 + 7, (467 + ((13 * 2) - 15)) - 2,
                    523 + 1.5, 467 + (13 * 2) - 2)
            ->relativeQuadraticBezierCurve(0, 2, 7, 6)
            ->relativeLineTo(-1.5, 4)->relativeLineTo(1, 4)
            ->relativeLineTo(-6.5, 4.5)->relativeLineTo(3, 5)
            ->relativeLineTo(-5.5, 4.5)
            ->relativeQuadraticBezierCurve(-3, 15, -14, 18.5)
            ->relativeLineTo(-1, 1)->relativeLineTo(-3.5, 10)
            ->relativeQuadraticBezierCurve(-3, 6, -10, 8)
            ->absoluteLineTo(482, 566)->absoluteLineTo(460, 585 + 1)
            /*->relativeLineTo(3, 10)*/ ->absoluteQuadraticBezierCurve(
                    463 + 42, 596, 463 + 48 + 1, 596 + 70 + 1)
            ->relativeQuadraticBezierCurve(5, -3, 25, -30)
            ->relativeQuadraticBezierCurve((70 / 2), (-115 / 2) - 3, 70, -115)
            ->relativeQuadraticBezierCurve(4, -15 / 3, 1, -15)
            ->relativeQuadraticBezierCurve(-8, -25*0.6, -7, -25) ?>"
          stroke-width="<?= $stroke ?>" stroke="#000000" fill="<?= $bgcolor ?>"
          opacity="<?= $opacity ?>" class="back-body"/>
    <path d="<?= new PathSVG(506, 420 - 1)->relativeLineTo(-7, -20)->rotationalLineTo(0, 12)
            ->absoluteMoveTo(234.5, 617) ?>" stroke-width="<?= $stroke ?>" stroke="#000000" class="front-body outline"/>
</g>
