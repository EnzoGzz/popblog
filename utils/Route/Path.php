<?php

namespace Utils\Route;

class Path
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $this->formatPath($path);
    }

    private function formatPath(string $path): string
    {
        return "/".rtrim(ltrim(trim($path,"/"),"/"),"/");
    }

    public function regexFormatPath()
    {
        $this->path = str_replace("/","\/",$this->path);
    }

    public function __toString(): string
    {
        return $this->path;
    }
}