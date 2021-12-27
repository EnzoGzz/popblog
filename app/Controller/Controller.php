<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Utils\Route\RouteExtension;

abstract class Controller
{
    private Environment $twig;
    protected EntityManager $em;
    protected array $errors = [];
    private RouteExtension $re;

    public function __construct()
    {
        global $em;
        $loader = new FilesystemLoader(__DIR__ . '/../../view');
        $this->twig = new Environment($loader);
        $this->twig->addGlobal("session",$_SESSION);
        $this->re = new RouteExtension();
        $this->twig->addExtension($this->re);
        $_COOKIE["errors"] = json_decode($_COOKIE["errors"] ?? null);
        $this->twig->addGlobal("cookie",$_COOKIE);
        $this->em = $em;
    }

    protected function render(string $name, array $args = [])
    {
        try{
            setcookie('errors', json_encode($this->errors), time() + 120);
            echo $this->twig->render("$name.twig",$args);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function route(string $name, array $args = []):string
    {
        return $this->re->route($name,$args);
    }

    protected function redirect(string $url):void
    {
        header("Location: ".$url);
    }

}