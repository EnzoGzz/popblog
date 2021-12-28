<?php

namespace Utils\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Utils\Route\Router;

class RouteExtension extends AbstractExtension
{
    public static function route(string $name,array $args = []):?string
    {
        if($route = Router::getByName($name)){
            return $route->buildPath($args);
        }
        return null;
    }

    public function getFunctions(): array
    {
        return[
            new TwigFunction("route",[self::class,"route"])
        ];
    }
}