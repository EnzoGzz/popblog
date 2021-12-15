<?php

namespace Utils\Route;

use Doctrine\ORM\EntityManager;
use Error;
use Exception;

class Router
{
    /**
     * @var array
     */
    private static array $routes = [];
    private static $_instance = null;

    private function __construct($em){
        try{
            require_once "routes.php";
            $path = $_SERVER['REQUEST_URI'];
            $route = self::matchFromPath(new Path($path));

            $controllerName = $route->getControllerName();
            $methodName = $route->getMethodName();
            $args = $route->getArgs();
            $controller = new $controllerName($em);
            if (!is_callable($controller)) {
                $controller =  [$controller, $methodName];
            }
            $controller(...array_values($args));
        }catch(Exception | Error $e){
            header('HTTP/1.0 404 Baise tes morts');
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

    public static function setup(EntityManager $em): ?Router
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new Router($em);
        }

        return self::$_instance;
    }

}