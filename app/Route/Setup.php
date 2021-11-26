<?php

namespace App\Route;

use Exception;

class Setup
{
    private Path $path;
    private Route $route;

    public function __construct()
    {
        try{
            $this->setPath($_SERVER['REQUEST_URI']);
            $this->route = Router::matchFromPath($this->path);
            $controllerName = $this->route->getControllerName();
            $methodName = $this->route->getMethodName();
            $args = $this->route->getArgs();
    
            $controller = new $controllerName();
            if (!is_callable($controller)) {
                $controller =  [$controller, $methodName];
            }
            echo $controller(...array_values($args));
        }catch(Exception $e){
            header('HTTP/1.0 404 Not Found');
        }
        
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = new Path($path);
    }


}