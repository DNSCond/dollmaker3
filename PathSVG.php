<?php const baseLastAngle = 270.0;
class PathSVG
{
    protected int|float $lastX;
    protected int|float $lastY;
    protected array $array = array();
    protected float $lastAngle = baseLastAngle; // Defaulting to "Down" (90° in SVG)

    public function __construct(int|float|null $startX, int|float|null $startY)
    {
        $this->array[] = ['command' => 'M', 'endX' => ($this->lastX = $startX), 'endY' => ($this->lastY = $startY)];
    }

    /**
     * the path in svg
     *
     * @return string
     */
    public function __toString(): string
    {
        $result = '';
        foreach ($this->array as $cmd) {
            $result = "$result {$cmd['command']} " . match ($cmd['command']) {
                    'a', 'A' => "{$cmd['rX']} {$cmd['rY']} {$cmd['angle']}" . " " .
                        "{$cmd['largeArcFlag']} {$cmd['sweepFlag']} {$cmd['endX']} {$cmd['endY']}",
                    'z', 'Z' => '',
                    'h', 'H' => "{$cmd['endX']}",
                    'V', 'v' => "{$cmd['endY']}",
                    'q', 'Q', 's', 'S', => "{$cmd['dX1']} {$cmd['dY1']} {$cmd['endX']} {$cmd['endY']}",
                    'c', 'C', => "{$cmd['dX1']} {$cmd['dY1']} {$cmd['dX2']} {$cmd['dY2']} {$cmd['endX']} {$cmd['endY']}",
                    default => "{$cmd['endX']} {$cmd['endY']}",
                };
        }
        return trim($result);
    }

    public function commandTo(string $cmd, array $args): self
    {
        return match ($cmd) {
            'm' => $this->relativeMoveTo(...$args),
            'M' => $this->absoluteMoveTo(...$args),
            'l' => $this->relativeLineTo(...$args),
            'L' => $this->absoluteLineTo(...$args),
            'a' => $this->relativeEllipticalArcCurve(...$args),
            'A' => $this->absoluteEllipticalArcCurve(...$args),
            'z', 'Z' => $this->closePath(),

            'h' => $this->relativeHorizontal(...$args),
            'H' => $this->absoluteHorizontal(...$args),
            'v' => $this->relativeVertical(...$args),
            'V' => $this->absoluteVertical(...$args),
            'q' => $this->relativeQuadraticBezierCurve(...$args),
            'Q' => $this->absoluteQuadraticBezierCurve(...$args),
            's' => $this->relativeSmoothCubicBezierCurve(...$args),
            'S' => $this->absoluteSmoothCubicBezierCurve(...$args),
            'c' => $this->relativeCubicBezierCurve(...$args),
            'C' => $this->absoluteCubicBezierCurve(...$args),
        };
    }

    /**
     * command "m"
     *
     * @param int|float $endX
     * @param int|float $endY
     * @return $this
     */
    public function relativeMoveTo(int|float $endX, int|float $endY): self
    {
        $isRelative = true;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'm',
            'endX' => $endX,
            'endY' => $endY,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    /**
     * command "M"
     *
     * @param int|float $endX
     * @param int|float $endY
     * @return $this
     */
    public function absoluteMoveTo(int|float $endX, int|float $endY): self
    {
        $isRelative = false;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'M',
            'endX' => $endX,
            'endY' => $endY,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    /**
     * command "l"
     *
     * @param int|float $endX
     * @param int|float $endY
     * @return $this
     */
    public function relativeLineTo(int|float $endX, int|float $endY): self
    {
        $isRelative = true;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'l',
            'endX' => $endX,
            'endY' => $endY,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    /**
     * command "L"
     *
     * @param int|float $endX
     * @param int|float $endY
     * @return $this
     */
    public function absoluteLineTo(int|float $endX, int|float $endY): self
    {
        $isRelative = false;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'L',
            'endX' => $endX,
            'endY' => $endY,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    /**
     * command "h"
     *
     * @param int|float $endX
     * @return $this
     */
    public function relativeHorizontal(int|float $endX): self
    {
        $isRelative = true;
        $this->updateLastAngle($endX, null, true);
        $this->array[] = [
            'command' => 'h',
            'endX' => $endX,
        ];
        return $this->updateCurrentPosition($endX, null, $isRelative);
    }

    /**
     * command "H"
     *
     * @param int|float $endX
     * @return $this
     */
    public function absoluteHorizontal(int|float $endX): self
    {
        $isRelative = false;
        $this->updateLastAngle($endX, null, false);
        $this->array[] = [
            'command' => 'H',
            'endX' => $endX,
        ];
        return $this->updateCurrentPosition($endX, null, $isRelative);
    }

    /**
     * command "v"
     *
     * @param int|float $endY
     * @return $this
     */
    public function relativeVertical(int|float $endY): self
    {
        $isRelative = true;
        $this->updateLastAngle(null, $endY, true);
        $this->array[] = [
            'command' => 'v',
            'endY' => $endY,
        ];
        return $this->updateCurrentPosition(null, $endY, $isRelative);
    }

    /**
     * command "V"
     *
     * @param int|float $endY
     * @return $this
     */
    public function absoluteVertical(int|float $endY): self
    {
        $isRelative = false;
        $this->updateLastAngle(null, $endY, false);
        $this->array[] = [
            'command' => 'V',
            'endY' => $endY,
        ];
        return $this->updateCurrentPosition(null, $endY, $isRelative);
    }

    /**
     * Adds an absolute Elliptical Arc (A) command to the path.
     *
     * @param int|float $rX The x-axis radius for the ellipse.
     * @param int|float $rY The y-axis radius for the ellipse.
     * @param int|float $angle The rotation of the ellipse relative to the x-axis (in degrees).
     * @param bool $largeArcFlag Take the long way around the oval? (true = yes).
     * @param bool $sweepFlag Curve clockwise? (true = yes).
     * @param int|float $endX The X coordinate where the curve ends.
     * @param int|float $endY The Y coordinate where the curve ends.
     * @return $this Returns the current instance for method chaining.
     */
    public function absoluteEllipticalArcCurve(
        int|float $rX, int|float $rY, int|float $angle,
        bool      $largeArcFlag, bool $sweepFlag,
        int|float $endX, int|float $endY): self
    {
        $isRelative = false;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'A',
            'endX' => $endX,
            'endY' => $endY,
            'largeArcFlag' => +$largeArcFlag,
            'rX' => $rX, 'rY' => $rY,
            'sweepFlag' => +$sweepFlag,
            'angle' => $angle,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    /**
     * Adds an relative Elliptical Arc (A) command to the path.
     *
     * @param int|float $rX The x-axis radius for the ellipse.
     * @param int|float $rY The y-axis radius for the ellipse.
     * @param int|float $angle The rotation of the ellipse relative to the x-axis (in degrees).
     * @param bool $largeArcFlag Take the long way around the oval? (true = yes).
     * @param bool $sweepFlag Curve clockwise? (true = yes).
     * @param int|float $endX The X coordinate where the curve ends.
     * @param int|float $endY The Y coordinate where the curve ends.
     * @return $this Returns the current instance for method chaining.
     */
    public function relativeEllipticalArcCurve(
        int|float $rX, int|float $rY, int|float $angle,
        bool      $largeArcFlag, bool $sweepFlag,
        int|float $endX, int|float $endY): self
    {
        $isRelative = true;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'a',
            'endX' => $endX,
            'endY' => $endY,
            'largeArcFlag' => +$largeArcFlag,
            'rX' => $rX, 'rY' => $rY,
            'sweepFlag' => +$sweepFlag,
            'angle' => $angle,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    public function absoluteCubicBezierCurve(
        int|float $dX1, int|float $dY1,
        int|float $dX2, int|float $dY2,
        int|float $endX, int|float $endY): self
    {
        $isRelative = false;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'C',
            'endX' => $endX,
            'endY' => $endY,
            'dX1' => $dX1,
            'dY1' => $dY1,
            'dX2' => $dX2,
            'dY2' => $dY2,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    public function relativeCubicBezierCurve(
        int|float $dX1, int|float $dY1,
        int|float $dX2, int|float $dY2,
        int|float $endX, int|float $endY): self
    {
        $isRelative = true;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'c',
            'endX' => $endX,
            'endY' => $endY,
            'dX1' => $dX1,
            'dY1' => $dY1,
            'dX2' => $dX2,
            'dY2' => $dY2,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    public function absoluteSmoothCubicBezierCurve(
        int|float $dX1, int|float $dY1,
        int|float $endX, int|float $endY): self
    {
        $isRelative = false;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'S',
            'endX' => $endX,
            'endY' => $endY,
            'dX1' => $dX1,
            'dY1' => $dY1,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    public function relativeSmoothCubicBezierCurve(
        int|float $dX1, int|float $dY1,
        int|float $endX, int|float $endY): self
    {
        $isRelative = true;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 's',
            'endX' => $endX,
            'endY' => $endY,
            'dX1' => $dX1,
            'dY1' => $dY1,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    public function absoluteQuadraticBezierCurve(
        int|float $dX1, int|float $dY1,
        int|float $endX, int|float $endY): self
    {
        $isRelative = false;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'Q',
            'endX' => $endX,
            'endY' => $endY,
            'dX1' => $dX1,
            'dY1' => $dY1,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    public function relativeQuadraticBezierCurve(
        int|float $dX1, int|float $dY1,
        int|float $endX, int|float $endY): self
    {
        $isRelative = true;
        $this->updateLastAngle($endX, $endY, $isRelative);
        $this->array[] = [
            'command' => 'q',
            'endX' => $endX,
            'endY' => $endY,
            'dX1' => $dX1,
            'dY1' => $dY1,
        ];
        return $this->updateCurrentPosition($endX, $endY, $isRelative);
    }

    /**
     * adds the "Z" command
     *
     * @return $this
     */
    public function closePath(): self
    {
        $this->array[] = ['command' => 'Z'];
        return $this;
    }

    /**
     * clones the current Point
     *
     * @param float|int $offsetX
     * @param float|int $offsetY
     * @return self
     */
    public function clonePath(float|int $offsetX = 0, float|int $offsetY = 0): self
    {
        ['x' => $x, 'y' => $y] = $this->getAbsolutePoint();
        return new self($x + $offsetX, $y + $offsetY);
    }

    /**
     * resets the current Path
     *
     * to create a path from absolute coords just use the constructor
     * @param float|int $offsetX
     * @param float|int $offsetY
     * @return $this
     */
    public function resetPath(float|int $offsetX = 0, float|int $offsetY = 0): self
    {
        ['x' => $x, 'y' => $y] = $this->getAbsolutePoint();
        $this->array = array(['command' => 'M', 'endX' => +($x + $offsetX), 'endY' => +($y + $offsetY)]);
        return $this;
    }

    private function updateCurrentPosition(int|float|null $lastX, int|float|null $lastY, bool $isRelative): self
    {
        if ($isRelative) {
            if ($lastX !== null) $this->lastX += $lastX;
            if ($lastY !== null) $this->lastY += $lastY;
        } else {
            if ($lastX !== null) $this->lastX = $lastX;
            if ($lastY !== null) $this->lastY = $lastY;
        }
        return $this;
    }

    /**
     * Calculates the final absolute (x, y) coordinates after all commands.
     * @return array{x: float|int, y: float|int}
     */
    public function getAbsolutePoint(): array
    {
        [$currentX, $currentY] = [$this->lastX, $this->lastY];
        return [$currentX, $currentY, 'x' => $currentX, 'y' => $currentY];
        /*$type = match ($cmd) {
            'M', 'L', 'H', 'V', 'C', 'S', 'Q', 'T', 'A', => 'abs',
            'm', 'l', 'h', 'v', 'c', 's', 'q', 't', 'a', => 'rel',
            'Z', 'z' => 'close',
        };
        $currentX = 0;
        $currentY = 0;

        foreach ($this->array as $cmd) {
            $type = $cmd['command'];

            switch ($type) {
                // Absolute commands: overwrite the current position
                case 'M':
                case 'L':
                case 'C':
                case 'S':
                case 'Q':
                case 'T':
                case 'A':
                    $currentX = $cmd['endX'] ?? $currentX;
                    $currentY = $cmd['endY'] ?? $currentY;
                    break;
                case 'H':
                    $currentX = $cmd['endX'];
                    break;

                case 'V':
                    $currentY = $cmd['endY'];
                    break;
                // Relative commands: add to the current position
                case 'm':
                case 'l':
                case 'c':
                case 's':
                case 'q':
                case 't':
                case 'a':
                    $currentX += $cmd['endX'] ?? 0;
                    $currentY += $cmd['endY'] ?? 0;
                    break;

                case 'h':
                    $currentX += $cmd['endX'] ?? 0;
                    break;

                case 'v':
                    $currentY += $cmd['endY'] ?? 0;
                    break;

                // 'Z' returns the pen to the start of the current sub-path.
                // For simple paths, this is usually the first 'M' coordinate.
                case 'Z':
                case 'z':
                    // Optional: implementation depends on if you track sub-path starts
                    break;
            }
        }

        return [$currentX, $currentY, 'x' => $currentX, 'y' => $currentY];
        */
    }

    /**
     * Draws a perfect semicircle to an absolute coordinate.
     * * @param int|float $endX Final X position.
     * @param int|float $endY Final Y position.
     * @param bool $clockwise Direction of the curve (true for clockwise).
     * @param int|float $radius The radius of the semicircle.
     * @return $this
     */
    public function semicircleTo(int|float $endX, int|float $endY, bool $clockwise, int|float $radius): self
    {
        // For a perfect semicircle:
        // 1. rX and rY are the same (it's part of a circle, not an ellipse).
        // 2. angle is 0 (rotation doesn't matter for a circle).
        // 3. largeArcFlag is false (a semicircle is exactly 180, not > 180).
        // 4. sweepFlag is your $clockwise parameter.

        return $this->absoluteEllipticalArcCurve(
            $radius,    // rX
            $radius,    // rY
            0,          // angle
            false,      // largeArcFlag (180 degrees)
            $clockwise, // sweepFlag
            $endX,
            $endY
        );
    }

    /**
     * Adds a relative line based on an angle and distance.
     *
     *
     * @param int|float $degClockwise Degrees to rotate clockwise from the base direction.
     * @param int|float $steps The length of the line.
     * @param bool $toUp If true, the angle is calculated relative to "Straight Up" (270°).
     * If false, it is calculated relative to the previous segment's angle.
     * @return $this
     */
    public function rotationalLineTo(int|float $degClockwise, int|float $steps, bool $toUp = false): self
    {
        $baseAngle = $toUp ? baseLastAngle : $this->lastAngle;

        // 2. Calculate the new absolute angle
        $newAngle = $baseAngle + $degClockwise;

        // 3. Convert to Radians for trig functions
        $radians = deg2rad($newAngle);

        // 4. Calculate relative X and Y
        $relX = cos($radians) * $steps;
        $relY = sin($radians) * $steps;

        // Use relativeLineTo (which calls updateLastAngle internally)
        return $this->relativeLineTo($relX, $relY);
    }

    private function updateLastAngle(?float $newX, ?float $newY, bool $isRelative): void
    {
        // For rotationalLineTo to work correctly, we only care about the direction
        // of the CURRENT segment being added.

        $current = $this->getAbsolutePoint();

        // Calculate the vector of the NEW segment
        if ($isRelative) {
            // In relative mode, the input IS the vector
            $dx = $newX ?? 0;
            $dy = $newY ?? 0;
        } else {
            // In absolute mode, vector = Target - Current
            $dx = ($newX !== null) ? ($newX - $current['x']) : 0;
            $dy = ($newY !== null) ? ($newY - $current['y']) : 0;
        }

        // Only update if there was actual movement (prevents atan2(0,0))
        if ($dx != 0 || $dy != 0) {
            $this->lastAngle = fmod(rad2deg(atan2($dy, $dx)) + 360, 360);
        }
    }

    public function getAbsolutePointString(?bool $comma = false): string
    {
        $comma = $comma ? "," : "";
        $array = $this->getAbsolutePoint();
        return "{$array['x']}$comma {$array['y']}";
    }

    public function toString(): string
    {
        return "$this";
    }

    /**
     * @param string $commandLetter how to get there
     * @param bool $toDown true if down, false is up
     * @param bool $toRight true if to the right, false is to the left
     * @return self
     */
    public function snapToIntegerGrid(string $commandLetter, bool $toDown, bool $toRight): self
    {
        [$x, $y] = $this->getAbsolutePoint();

        // Handle X (Horizontal) - Right is positive X
        $x = $toRight ? ceil($x) : floor($x);

        // Handle Y (Vertical) - Down is positive Y in SVG
        $y = $toDown ? ceil($y) : floor($y);

        return $this->commandTo($commandLetter, [$x, $y]);
    }
}

require_once 'KeywordValidator.php';
