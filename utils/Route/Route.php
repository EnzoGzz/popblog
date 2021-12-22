<?php

namespace Utils\Route;

class Route
{
    private Path $path;
    private array $variables = [];
    private array $methodsHTTP;
    private string $controller;
    private string $method;
    private string $name;

    public function __construct(string $path,array $params,string $name, array $methods = ["GET"])
    {
        $this->path = new Path($path);
        $this->path->regexFormatPath();
        $this->controller = $params[0];
        $this->method = $params[1];
        $this->name = $name;
        $this->methodsHTTP = $methods;
        Router::add($this);
    }

    public function extractVarsNames(): array
    {
        preg_match_all('/{[^}]*}/', $this->path, $matches);
        return reset($matches) ?? [];
    }


    public function match(Path $path, string $method):bool
    {
        $regex = preg_replace("/{[^}]*}/","([^\/]+)",$this->path);
        $regex = "/^".$regex."$/";
        if(preg_match_all($regex,$path,$variables) && in_array($method,$this->methodsHTTP)){
            unset($variables[0]);
            $this->variables = $variables !== [] ? reset($variables) : [];
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    public function buildPath(array $arguments): Path
    {
        $varsName = $this->extractVarsNames();
        return new Path(preg_replace($varsName,$arguments,$this->path));
    }
}