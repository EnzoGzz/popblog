<?php

namespace Utils\Route;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{
    public function route(string $name,array $args = []):?string
    {
        if($route = Router::getByName($name)){
            return $route->buildPath($args);
        }
        return null;
    }

    public function getFunctions(): array
    {
        return[
            new TwigFunction("route",function ($name,$args = []){
                echo $this->route($name,$args);
            })
        ];
    }
}