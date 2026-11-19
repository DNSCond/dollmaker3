<?php use DataViewed\BinaryView;
use function DataViewed\RGBA32ToRGB;
use function DataViewed\RGBToRGBA32;
use function Helpers\Getters\isPresent;

require_once "getColor.php";
require_once "BinaryHelper.php";
const maxAssetCount = 50, ColorConstantIndex = 10;

class AssetHelper
{
    private int $dirByte;
    private int $assetCount;
    private array $colors = [];
    private array $assets = [];

    public function __construct(string $base64String, int $version)
    {
        $binaryView = BinaryView::fromBase64URL($base64String);
        $offset = 0;
        if ($version !== 1 && $version !== 2) {
            throw new InvalidArgumentException("\$version isnt 1 or 2");
        }

        // 1. Extract 10 times an uint32 using RGBA32ToRGB into colors array
        for ($i = 0; $i < ($version === 1 ? 7 : 10); $i++) {
            $this->colors[] = colorIntToString(RGBA32ToRGB($binaryView, $offset));
            $offset += 4;
        }
        if ($version === 2) {
            // 2. Extract uint16 into dirByte (little endian)
            $this->dirByte = $binaryView->getUint16($offset);
            $offset += 2;
        } else {
            $this->dirByte = $binaryView->getUint8($offset++);
        }

        // 3. Extract uint8 into assetCount
        $this->assetCount = $binaryView->getUint8($offset);
        $offset += 1;

        // 4. Grab an uint16 followed by an uint8 assetCount times
        for ($i = 0; $i < $this->assetCount && $i < maxAssetCount; $i++) {
            $value1 = $binaryView->getUint16($offset);
            $offset += 2;

            $value2 = $binaryView->getUint8($offset);
            $offset += 1;

            $this->assets[] = ['id' => $value1, 'opt' => $value2];
        }

        // 5. Remaining bytes are ignored automatically.
    }

    public function getDirection(): string
    {
        $dirByte = $this->dirByte;
        $frontBack = (bool)($dirByte & (1 << 0));
        $leftRight = (bool)($dirByte & (1 << 1));
        $deg45 = (bool)($dirByte & (1 << 2));
        $direction = ($frontBack ? 'b' : 'f') . ($leftRight ? 'l' : 'r');
        if ($deg45) $direction = match ($direction) {
            'bl' => 'b-',
            'br' => '-r',
            'fl' => '-l',
            'fr' => 'f-',
        };
        return $direction;
        //$y = match ($direction[0]) {'f' => 'Front', 'b' => 'Back', default => '-'};
        //$x = match ($direction[1]) {'r' => 'Right', 'l' => 'Left', default => '-'};
    }

    public function canonicalize(): array
    {
        $new = array();
        global $assetdata, $colorList;
        $matchedAssets = array(0 => true);
        $assetCount = count($this->assets);
        $direction = $this->getDirection();
        for ($i = 0; $i < $assetCount; $i++) {
            $assetId = $this->assets[$i]['id'];
            $assetOpt = $this->assets[$i]['opt'];
            if (array_key_exists($assetId, $matchedAssets)) continue;
            $assetIdStr = str_pad($assetId, 4, '0', STR_PAD_LEFT);
            if (!isPresent($assetdata, ['d', $assetIdStr, $direction])) continue;
            $new[] = array('id' => $assetId, 'opt' => $assetOpt);
        }
        $canonicalColorIndex = 0;
        $assetCount = count($new);
        $colors = $this->getComputedColors();
        usort($new, fn($le, $ri) => $le['id'] - $ri['id']);
        $canonicalized = new BinaryView((ColorConstantIndex * 4) + 2 + 1 + ($assetCount * 3));
        foreach ($colorList as $name) {
            $colorInt = normalizeColor($colors[$name]);
            if (is_int($colorInt)) {
                RGBToRGBA32($canonicalized, $colorInt, $canonicalColorIndex++ * 4);
            } else $canonicalColorIndex++;
        }
        $canonicalColorIndex = ColorConstantIndex * 4;
        $canonicalized->setUint16($canonicalColorIndex++, $this->dirByte);
        $canonicalized->setUint8(++$canonicalColorIndex, $assetCount);
        foreach ($new as $asset) {
            $canonicalized->setUint16(++$canonicalColorIndex, +$asset['id']);
            ++$canonicalColorIndex;
            $canonicalized->setUint8(++$canonicalColorIndex, +$asset['opt']);
        }
        return ['v2u.', $canonicalized->toBase64URL(), 2];
    }

    public function getColors(): array
    {
        return $this->colors;
    }

    public function getComputedColors(): array
    {
        $result = array();
        global $colorList;
        foreach ($colorList as $value => $name)
            if (array_key_exists($value, $this->colors))
                $result[$name] = $this->colors[$value];
        return completeColorArray($result);
    }

    public function getDirByte(): int
    {
        return $this->dirByte;
    }

    public function getAssetCount(): int
    {
        return $this->assetCount;
    }

    public function getAssets(): array
    {
        return $this->assets;
    }

    public function getPFPMode(): bool
    {
        return $this->dirByte & (1 << 4);
    }

    public function getOpaque(): bool
    {
        return $this->dirByte & (1 << 3);
    }

    public function addAsset(int $assetId, int $assetOpt): void
    {
        $this->assets[] = array('id' => $assetId, 'opt' => $assetOpt);
    }

    public function toBase64URL(): string
    {
        return $this->canonicalize()[1];
    }

    public function clearAssets(): void
    {
        $this->assets = array();
    }
}
