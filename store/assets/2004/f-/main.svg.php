<svg>
    <g><?= $rays = 15;
        $cx = 400;
        $cy = 525;
        $innerRadius = 40;
        $outerRadius = 35 * 2;
        $c = "{$GLOBALS['colors']['lights']}";

        $step = 360 / $rays;
        for ($i = 0; $i < $rays; $i++) {
            $a1 = deg2rad($i * $step - $step / 4);
            $a2 = deg2rad($i * $step);
            $a3 = deg2rad($i * $step + $step / 4);

            $x1 = $cx + cos($a1) * $innerRadius;
            $y1 = $cy + sin($a1) * $innerRadius;

            $x2 = $cx + cos($a2) * $outerRadius;
            $y2 = $cy + sin($a2) * $outerRadius;

            $x3 = $cx + cos($a3) * $innerRadius;
            $y3 = $cy + sin($a3) * $innerRadius;

            echo "<polygon points='$x1,$y1 $x2,$y2 $x3,$y3' fill='$c' stroke='$c' stroke-width='2'/>\n";
        } ?></g>
    <circle stroke='black' stroke-width='2'
            cx="400" cy="525" r="35"
            fill="<?= $c ?>"/>
</svg>