<svg>
    <rect width="420" height="80" x="20" y="20" fill="#fff100"/>
    <!-- keepIntact -->
    <g fill="none" stroke-width="4" stroke="#000000" stroke-linecap="round" stroke-linejoin="round">
        <path d="M 50 40 l -15 40 M 50 40 l 15 40 m -32 -15 l 35 0" data-letter="A"/>
        <path d="M 75 80 v -40 l 25 40 v -40" data-letter="N"/>
        <path d="M 105 40 h 30 h -15 v 40" data-letter="T"/>
        <!-- -->
        <path d="<?= new PathSVG($x = 140, 40)->relativeHorizontal(20)
                ->semicircleTo($x + 20, 40 + 20, true, 5)
                ->relativeLineTo(10, 20)->relativeLineTo(-10, -20)
                ->relativeHorizontal(-20)->absoluteLineTo($x, 40)
                ->relativeVertical(40)->closePath() ?>" data-letter="R"/>
        <path d="<?= new PathSVG(180, 40)->relativeHorizontal(20)
                ->relativeHorizontal(-20)->relativeVertical(20)
                ->relativeHorizontal(20)->relativeHorizontal(-20)
                ->relativeVertical(20)->relativeHorizontal(20) ?>"
              data-letter="E"/>
        <g data-letter="Q">
            <circle r="20" cx="226" cy="60"/>
            <path d="<?= new PathSVG(226, 60)->relativeLineTo(25, 25) ?>" data-letter="Q"/>
        </g>
        <path d="M 255 40 v 40 h 20 v -40" data-letter="U"/>
        <path d="<?= new PathSVG(285, 40)->relativeHorizontal(20)
                ->relativeHorizontal(-20)->relativeVertical(20)
                ->relativeHorizontal(20)->relativeHorizontal(-20)
                ->relativeVertical(20)->relativeHorizontal(20) ?>"
              data-letter="E"/>
        <path d="M 335,47 c 0,-10 -20,-10 -20,0 c 0,10 20,16 20,26 c 0,10 -20,10 -20,0" data-letter="S"/>
        <path d="M 340 40 h 30 h -15 v 40" data-letter="T"/>
        <circle r="4" cx="<?= 372 - 5 ?>" cy="<?= 80 - 3 ?>" fill="#000000" data-letter="."/>
        <path d="M 380 80 v -40 l 25 40 v -40" data-letter="N"/>
        <path d="M 415 40 v 40 h 15" data-letter="L"/>
    </g>
</svg>
