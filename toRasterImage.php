<?php use function Helpers\Mime\get_accept_mimetype;
use function Helpers\sha256;
use function Helpers\cbyte;

//BIGCOMMWENT

function toRasterImage(string $svg_string, bool|string $supportIco = false): bool
{
    $correctMimetype = false;
    header('vary: accept', false);
    $icons = explode(', ', 'image/vnd.microsoft.icon, image/x-icon, image/ico,application/ico');
    if (is_bool($supportIco) && !$supportIco) $icons = array();
    $mimetype = get_accept_mimetype($haystack = ['image/svg+xml', 'image/png', 'image/jpeg', ...$icons], true);
    $mimetype = (array_key_exists('type', $_GET) && in_array("{$_GET['type']}", $haystack)) ? "{$_GET['type']}" : $mimetype;
    if (is_string($supportIco) && in_array($supportIco, $haystack)) $mimetype = $supportIco;
    if (!is_null($mimetype) && 'image/svg+xml' !== $mimetype) {
        header("content-type:" . (match ($mimetype) {
                "image/vnd.microsoft.icon", "image/x-icon", "image/ico", "application/ico" => 'image/vnd.microsoft.icon',
                default => $mimetype,
            }));
        $im = new Imagick;
        //$svg_string = str_replace('<!--setBackgroundColor-white-->', '<rect fill="white" width="800" height="1280"/>', $svg_string);
        $svg_string = preg_replace('/<(path|rect|ellipse|circle|line|poly(?:line|gon))/', '<${1} shape-rendering="crispEdges"', $svg_string);
        try {
            $im->setBackgroundColor(new ImagickPixel('transparent'));
            //$im->readImageBlob("data:image/svg+xml;base64," . base64_encode($svg_string));
            //$im->readImageBlob("$xmlHeader<svg><svg width=\"800\" height=\"1280\" xmlns=\"http://www.w3.org/2000/svg\" stroke-width=\"8\" stroke=\"#000000\"><rect fill=\"white\" width=\"800\" height=\"1280\"/></svg>");
            $im->readImageBlob("$svg_string");
            //if (in_array($mimetype, ['image/svg+xml', 'image/png'])) {
            //    //$im->setImageAlphaChannel(Imagick::ALPHACHANNEL_TRANSPARENT);
            //    $im->setImageAlphaChannel(Imagick::ALPHACHANNEL_TRANSPARENT);
            //    $im->setBackgroundColor(new ImagickPixel('transparent'));
            //    header('transparency: true');
            //} else {
            //    header('transparency: false');
            //}
            header("mimetype: $mimetype");
            $im->setImageFormat(match ($mimetype) {
                "image/vnd.microsoft.icon", "image/x-icon", "image/ico", "application/ico" => 'ico',
                "image/jpeg" => "jpeg",
                'image/svg+xml' => 'image/svg+xml',
                default => "png32",
            });
            if (in_array($mimetype, $icons)) {
                $im->resizeImage(256, 256, Imagick::FILTER_LANCZOS, 0);
            }
            $string = $im->getImageBlob();
            $im->clear();
            $correctMimetype = true;
        } catch (ImagickException) {
            header("content-type:image/svg+xml");
            $im->clear();
            $string = $svg_string;
        }
    } else {
        header('content-type:image/svg+xml');
        $string = $svg_string;
    }
    $cbyte = cbyte($strlen = strlen($string));
    $hashtag = sha256("$string");
    header("nice-content-length: $cbyte");
    header("car-content-length: $strlen");
    header("hashtag:\"$hashtag\"");
    header("etag:\"$hashtag\"");
    header("correct-Mimetype: " . ($correctMimetype ? 'true' : 'false'));
    //foreach (preg_split('/\\r?\\n/', rtrim($svg_string)) as $lineN => $line) {
    //header("svgLine-$lineN: " . json_fromArray($line));}
    echo "$string";
    return $correctMimetype;
}
