<svg>
    <rect x="0" y="0" width="800" height="1280" fill="#000000" opacity="<?= hasOption(1) ? '0' : '0.5' ?>"/>
    <!--<?= hasOption(1) ? 'true' : 'false';
    global $pfpMode;
    $subtract = 0;//(bool)$pfpMode * 250;
    $handle = 450 - $subtract;
    $bottom = $handle + 50 ?>-->
    <path d="<?= "M 250 $handle A 50 50 5 0 1 550 $handle V $bottom H 500 V $handle A 50 50 5 0 0 300 $handle V $bottom H 250 Z" ?>"
          fill="#808080"/>
    <rect x="200" y="<?= 500 - $subtract ?>" width="400" height="400" fill="#a66b00"/>
    <circle r="50" cx="400" cy="600" fill="#000000"/>
    <path d="M 400 600 L 300 850 L 500 850"/>
</svg>