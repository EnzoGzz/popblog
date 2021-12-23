<?php

namespace Utils\Route;

class Path
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function normalFormatPath():Path
    {
        return new Path("/".rtrim(ltrim(trim($this->path,"/"),"/"),"/"));
    }

    public function regexFormatPath(): Path
    {
        return new Path(str_replace("/","\/",$this->path));
    }

    public function __toString(): string
    {
        return $this->path;
    }
}