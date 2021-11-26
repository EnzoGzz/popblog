<?php

namespace App\Route;

use JetBrains\PhpStorm\Pure;

class Path
{
    protected string $path;

    #[Pure] public function __construct(string $path)
    {
        $this->path  = self::formatPath($path);
    }

    public static function formatPath(string $path): string
    {
        return "/".rtrim(ltrim(trim($path,"/"),"/"),"/");
    }

    public function __toString(): string
    {
        return $this->path;
    }


}