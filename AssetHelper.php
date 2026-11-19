<?php use DataViewed\BinaryView;
use function DataViewed\RGBA32ToRGB;
use function DataViewed\RGBToRGBA32;
use function Helpers\Getters\isPresent;

require_once "getColor.php";
require_once "BinaryHelper.php";
const maxAssetCount = 50, ColorConstantIndex = 10;
class AssetHelper
{
    private BinaryView $internal;
    private array $colors = array();
    private array $assets = array();
    public bool $pfpMode = false;
    public bool $opaque = false;
    private int $dirByte = 0b100;

    public function __construct(string $dnastring, int $version)
    {
        $this->internal = $binaryHelper = BinaryView::fromBase64URL($dnastring);
        if ($version === 1) {
            $colors = 7;
        } elseif ($version === 2) {
            $colors = 10;
        } else throw new InvalidArgumentException("\$version isnt 1 or 2");
        $this->putColors();
        $dirByte = 0;
        $index = $colors * 4;
        if ($version === 1) {
            // F is Front, R is Right, L is Left, B is Back
            $dirByte = $binaryHelper->getUint8($index++);
        } elseif ($version === 2) {
            // F is Front, R is Right, L is Left, B is Back
            $dirByte = $binaryHelper->getUint16($index++);
            $index++;
        }
        $this->pfpMode = (bool)($dirByte & (1 << 4));
        $this->opaque = (bool)($dirByte & (1 << 3));
        $this->dirByte = $dirByte;
        $direction = $this->getDirection();
        global $assetdata;
        $assetCount = $binaryHelper->getUint8($index++);
        $assetCount = $assetCount === false ? 0 : $assetCount;
        $assetCount = max(min($assetCount, maxAssetCount), 0);
        for ($i = 0; $i < $assetCount; $i++) {
            $offset = $index + $i * 3;
            $assetId = $binaryHelper->getUint16($offset);
            $assetOpt = $binaryHelper->getUint8($offset + 2);
            $assetIdStr = str_pad($assetId, 4, '0', STR_PAD_LEFT);
            if (!isPresent($assetdata, ['d', $assetIdStr, $direction])) continue;
            $this->assets[] = array('id' => $assetId, 'opt' => $assetOpt);
        }
        usort($this->assets, fn($le, $ri) => $le['id'] - $ri['id']);
    }

    public function __toString(): string
    {
        return "v2u.{$this->toBase64URL()}";
    }

    public function toBase64Url(bool $canonicalize = false): string
    {
        if ($canonicalize) return $this->canonicalize_private()->toBase64URL();
        return $this->internal->toBase64URL();
    }

    private function canonicalize_private(): BinaryView
    {
        global $colorList;
        $canonicalColorIndex = 0;
        $assetCount = count($this->assets);
        $canonicalized = new BinaryView((ColorConstantIndex * 4) + 2 + 1 + ($assetCount * 3));
        foreach ($colorList as $value) {
            $colorInt = normalizeColor($this->colors[$value]);
            if (is_int($colorInt)) {
                RGBToRGBA32($canonicalized, $colorInt, $canonicalColorIndex++ * 4);
            } else $canonicalColorIndex++;
        }
        $i = 0;
        $canonicalColorIndex = ColorConstantIndex * 4;
        $matchedAssets = array(0 => true);
        $canonicalized->setUint16($canonicalColorIndex, ($this->dirByte
                & 0b111) | ($this->opaque << 3) | ($this->pfpMode << 4));
        $canonicalColorIndex += 3; // 2 bytes dirByte + 1 byte asset count

        $assetsCounted = 0;
        usort($this->assets, fn($le, $ri) => $le['id'] - $ri['id']);
        foreach ($this->assets as $asset) {
            ['id' => $assetId, 'opt' => $assetOpt] = $asset;
            if (array_key_exists($assetId, $matchedAssets)) continue;
            $matchedAssets[$assetId] = true;
            $index = $canonicalColorIndex + ($i++ * 3);
            $canonicalized->setUint16($index, $assetId);
            $canonicalized->setUint8($index + 2, $assetOpt);
            $assetsCounted++;
        }

        $canonicalized->setUint8((ColorConstantIndex * 4) + 2, $assetsCounted);
        $canonicalized->resize((ColorConstantIndex * 4) + 2 + 1 + ($assetsCounted * 3));
        return $this->internal = $canonicalized;
    }

    public function canonicalize(): self
    {
        return new self($this->canonicalize_private()->toBase64URL(), 2);
    }

    private function putColors(): void
    {
        global $colorList;
        $colorArray = array();
        $binaryHelper = BinaryView::fromBase64URL("{$this->toBase64Url(true)}");
        foreach ($colorList as $keyDex => $key) {
            try {
                $normalized = normalizeColor(RGBA32ToRGB($binaryHelper, $keyDex * 4));
                if (is_int($normalized)) $colorArray[$key] = colorIntToString($normalized);
            } catch (OutOfBoundsException) {
            }
        }
        $this->colors = completeColorArray($colorArray);
    }

    public function getAssets(): array
    {
        return $this->assets;
    }

    public function getDirByte(): false|int
    {
        return $this->dirByte;
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

    public function getColors(): array
    {
        return $this->colors;
    }

    public function cloneColors(): self
    {
        $view = new BinaryView("$this");
        $view->resize(ColorConstantIndex * 4 + 3);
        return new self($view->toBase64URL(), 2);
    }

    public function addAsset(int $assetId, int $option): void
    {
        if ($assetId <= 0 || $assetId > 65535 || $option < 0 || $option > 255) {
            throw new InvalidArgumentException("RangeError (\$assetId=$assetId, \$option=$option)");
        }
        $this->assets[] = array('id' => $assetId, 'opt' => $option);
    }
}
