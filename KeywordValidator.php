<?php

class KeywordValidator
{
    private array $keywords;

    public function __construct(?array $array)
    {
        $this->keywords = $array ?? array();
    }

    public function test(string $keyword): bool
    {
        return in_array($keyword, $this->keywords);
    }

    public function validate(string $keyword, ?string $default = null): ?string
    {
        if (in_array($keyword, $this->keywords)) return $keyword;
        return $default;
    }

    public function validateGETParam(string $getParam, ?string $default = null): ?string
    {
        if (array_key_exists($getParam, $_GET)) {
            $getParam = "$_GET[$getParam]";
            if (in_array($getParam, $this->keywords)) {
                return $getParam;
            }
        }
        return $default;
    }

    public function add(string $keyword): string
    {
        $this->keywords[] = $keyword;
        return $keyword;
    }

    public function __toString(): string
    {
        return implode(',', $this->keywords);
    }

    public function toString(string $seperator = ','): string
    {
        return implode($seperator, $this->keywords);
    }

    public function asArray(): array
    {
        return $this->keywords;
    }
}

