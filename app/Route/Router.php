<?php

namespace App\Route;

use Error;
use Exception;

class Router
{
    /**
     * @var array
     */
    private static array $routes = [];

    public function __construct(){
        try{
            require_once "routes.php";
            $path = $_SERVER['REQUEST_URI'];
            $route = self::matchFromPath(new Path($path));
            $controllerName = $route->getControllerName();
            $methodName = $route->getMethodName();
            $args = $route->getArgs();
            $this->exec($controllerName,$methodName,$args);
        }catch(Exception | Error $e){
            echo "404 Not found";
            echo $e->getMessage();
        }
    }

    /**
     * @param Route $route
     */
    public static function add(Route $route){
        self::$routes[] = $route;
    }

    /**
     * @param Path $path
     * @return Route
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

    /**
     * @param string $controllerName
     * @param string $methodName
     * @param array $args
     */
    private function exec(string $controllerName, string $methodName, array $args)
    {
        $controller = new $controllerName();
        if (!is_callable($controller)) {
            $controller =  [$controller, $methodName];
        }
        $controller(...array_values($args));
    }

}