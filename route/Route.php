<?php

class Route{
    private $className;
    private $method;

    private function __construct(string $path, array $params)
    {
        $this->className = $params[0];
        $this->method = $params[1];
    }

    public static function create(string $path, array $params)
    {
        $a = new self($path,$params);

    }
}
