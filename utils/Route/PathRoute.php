<?php

namespace Utils\Route;

class PathRoute extends Path
{
    private string $pathPattern;
    private array $vars = [];
    private array $varsName;


    public function __construct(string $path)
    {
        $t = self::formatPath(str_replace("index.php","",$_SERVER["SCRIPT_NAME"]));
        parent::__construct(new Path($t.$path));
        $this->setPathPattern();
        $this->extractVarsName($this);
    }

    private function setPathPattern(){

        $pathPattern = str_replace("/","\/",$this->path);

        $this->pathPattern = preg_replace("/{[:a-zA-z0-9-_]+}/","([:a-zA-z0-9-_]+)",$pathPattern);
        $this->pathPattern = "/^".$this->pathPattern."$/";
    }

    public function matchWith(Path $path): bool|int
    {
        return $this->extractVars($path);
    }

    /**
     * @return array
     */
    public function getVars(): array
    {
        return $this->vars;
    }

    /**
     * @return array
     */
    public function getVarsName(): array
    {
        return $this->varsName;
    }

    private function extractVarsName(Path $path): void
    {
        preg_match_all("/{[:a-zA-z0-9-_]+}/",$path,$varsName);
        $this->varsName = $varsName[0];
    }

    private function extractVars(Path $path): bool|int
    {
        $match = preg_match_all($this->pathPattern,$path,$vars);
        if($match){
            array_shift($vars);
            if($vars != []){
                $this->vars = $vars[0];
            }
        }
        return $match;
    }


}