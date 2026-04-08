<?php use DataViewed\DataView;

require_once "{$_SERVER['DOCUMENT_ROOT']}/require/createHead2.php";
require_once "BinaryHelper.php";
header('content-type: application/json');

if (preg_match('/^#?([a-f-A-F0-9]{6});#?([a-f-A-F0-9]{6});#?([a-f-A-F0-9]{6})$/D',
    "{$_POST['body']};{$_POST['skin']};{$_POST['eyes']}", $matches)) {
    $result = new DataView;
    $result->insertColorRGBAIntToByteArrayAt(hexdec($matches[1]), $result->getLength());
    $result->insertColorRGBAIntToByteArrayAt(hexdec($matches[2]), $result->getLength());
    $result->insertColorRGBAIntToByteArrayAt(hexdec($matches[3]), $result->getLength());
    $dnastring = "v1u." . DataView::uint8ArrayToBase64Url($result->asArray());
    http_response_code(303);
    header("Location: /dollmaker3/$dnastring/");
    exit;
}
echo '{"error":400}';
