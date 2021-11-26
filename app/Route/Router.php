<?php

namespace App\Route;

use Exception;

class Router
{
    private static array $routes = [];

    public static function add(Route $route){
        self::$routes[] = $route;
    }

    /**
     * @throws Exception
     */
    public static function matchFromPath(Path $path):Route
    {
        foreach(self::$routes as $route)
        {
            if($route->match($path)){
                return $route;
            }
        }
        throw new Exception("No route found");
    }
}