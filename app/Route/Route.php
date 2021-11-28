<?php

namespace App\Route;

class Route{
    private PathRoute $pathRoute;
    private string $controllerName;
    private string $methodName;
    private array $args;

    private function __construct(string $path, array $params)
    {
        $this->pathRoute = new PathRoute($path);
        $this->controllerName = $params[0];
        $this->methodName = $params[1] ?? null;
    }

    public function match(Path $path):bool
    {
        $matched = $this->pathRoute->matchWith($path);
        if($matched){
            $this->args = array_combine($this->pathRoute->getVarsName(),$this->pathRoute->getVars());
        }
        return $matched;
    }

    public static function create(string $path, array $params):Route
    {
        $route = new self($path,$params);
        Router::add($route);
        return $route;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return mixed
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

}
