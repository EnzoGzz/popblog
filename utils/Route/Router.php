<?php

namespace Utils\Route;

use Exception;

class Router
{
    private static array $routes = [];

    public function __construct()
    {
        try{
            require_once "routes.php";
            $method = $_SERVER["REQUEST_METHOD"];
            $path = new Path($_SERVER["REQUEST_URI"]);
            $route = $this->getRouteMatch($path,$method);
            $controller = $route->getController();
            $method = $route->getMethod();
            $parameters = $route->getVariables();
            $controller = new $controller();
            if (!is_callable($controller)) {
                $controller =  [$controller, $method];
            }
            $controller(...array_values($parameters));

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function add(Route $route)
    {
        self::$routes[] = $route;
    }

    /**
     * @throws Exception
     */
    private function getRouteMatch(Path $path, $method):Route
    {
        foreach (self::$routes as $route)
        {
            if($route->match($path,$method)){
                return $route;
            }
        }
        throw new Exception("No route matched");
    }
}