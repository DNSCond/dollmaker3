<?php use Random\RandomException;

date_default_timezone_set('UTC');
header('vary: *');
header('accept-ch: Sec-CH-UA-Mobile, Sec-CH-UA-Platform,'
        . ' Sec-CH-UA-Form-Factors, Sec-CH-Viewport-Height, Sec-CH-Viewport-Width');
header('critical-ch: Sec-CH-UA-Mobile, Sec-CH-UA-Platform,'
        . ' Sec-CH-UA-Form-Factors, Sec-CH-Viewport-Height, Sec-CH-Viewport-Width');
$style = 'body{font-family:monospace}';
$styleHashed = 'sha256-' . sha256Base64($style);
/** @noinspection PhpUnhandledExceptionInspection */
$nonce = nonceBase64(16, true);
header("content-security-policy: default-src 'none'; style-src-elem 'unsafe-hashes' '$styleHashed';  script-src-elem '$nonce'");
echo '<!DOCTYPE html><html lang=en><meta charset=UTF-8><title>HTTP Request Viewer</title><meta name=viewport' .
        " content='width=device-width,initial-scale=1'><style>$style</style>";
function sha256Base64(string $string): string
{
    return base64_encode(hash('sha256', $string, true));
}

function htmlspecialchars_2(string $value): string
{
    $html = str_replace('"', '&quot;',
            str_replace('>', '&gt;',
                    str_replace('<', '&lt;',
                            str_replace('\'', '&#39;',
                                    str_replace('&', '&amp;',
                                            "$value")))));
    return ($html);
}

function nonceBase64(int $length = 16, bool $strict = false): string
{
    try {
        return 'nonce-' . base64_encode(random_bytes($length));
    } catch (RandomException$e) {
        if ($strict) /** @noinspection PhpUnhandledExceptionInspection */ throw $e;
        return 'null';
    }
}

$attributes = array();
$dl = '';
function appendHeader(string $headerName, string $headerValue, string $type = 'text'): void
{
    global $attributes, $dl;
    $headerNameHTML = htmlspecialchars_2(substr($headerName, 5));
    $headerNameHTML = str_replace('_', '-', $headerNameHTML);
    $headerValueHTML = htmlspecialchars_2($headerValue);
    $attributes[] = "data-headerget-$headerNameHTML=\"$headerValueHTML\"";
    $headerNameHTML = normalizeHeaderName($headerNameHTML);
    $dl .= "\x0a<dt>$headerNameHTML<dd>" . match ($type) {
                'time' => (function () use ($headerValueHTML, $headerValue) {
                    $gmdate = strtotime($headerValue);
                    if ($gmdate === false) return "$headerValueHTML (local=unknown)";
                    $datetime = gmdate('Y-m-d\\TH:i:s\\Z', $gmdate);
                    $innerHTML = gmdate(DATE_RFC7231, $gmdate);
                    return "$headerValueHTML (local=<time datetime=$datetime>$innerHTML</time>)";
                })(),
                default => $headerValueHTML,
            };
}

appendHeader('HTTP_Favicond-HTTP-Method', $_SERVER['REQUEST_METHOD']);
appendHeader('HTTP_Favicond-HTTP-Time', gmdate(DATE_RFC7231, $_SERVER['REQUEST_TIME']), 'time');
foreach ($_SERVER as $headerName => $headerValue) {
    if (str_starts_with($headerName, 'HTTP_') && preg_match('/^HTTP_[A-Z_0-9]+$/D', $headerName)) {
        if (in_array($headerName, ['HTTP_COOKIE', 'HTTP_AUTHORIZATION'])) continue;
        appendHeader($headerName, $headerValue, match ($headerName) {
            'HTTP_DATE' => 'time',
            default => 'text',
        });
    }
}
function normalizeHeaderName(string $name): string
{
    $name = strtolower(str_replace('_', '-', $name));
    return implode('-', array_map('ucfirst', explode('-', $name)));
}

$attributesBody = "\x0a" . implode("\x0a", $attributes);
echo "<body id=binarygame $attributesBody><h1>HTTP Request Viewer</h1><dl>$dl\x0a</dl>" ?>
<script type=module nonce="<?= substr($nonce, 6) ?>">
    const entries = Object.entries(document.body.dataset).map(([name, value]) => [name.replace(/^headerget/i, ''), value]);
    console.log(JSON.stringify(Object.fromEntries(entries), null, 2));
    // const dl = document.querySelector('dl');
    // dl.replaceChildren();
    // for (const entry of entries) {
    //     const dt = document.createElement('dt'), dd = document.createElement('dd');
    //     dt.textContent = entry[0].replace(/[A-Z]+/g, '-$&').replace(/^-+/, '');
    //     dd.textContent = entry[1];
    //     dl.append(dt, dd);
    // }
    document.querySelectorAll('time').forEach(each => each.textContent = new Date(each.dateTime));
</script>
