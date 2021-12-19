<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private Environment $twig;
    protected EntityManager $em;
    protected array $errors = [];

    public function __construct(EntityManager $em)
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../view');
        $this->twig = new Environment($loader);
        $this->twig->addGlobal("session",$_SESSION);
        $_COOKIE["errors"] = json_decode($_COOKIE["errors"] ?? null);
        $this->twig->addGlobal("cookie",$_COOKIE);
        $this->em = $em;
    }

    protected function render(string $name, array $args = [])
    {
        try{
            echo $this->twig->render("$name.twig",$args);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function redirect(string $url)
    {
        header("Location: ".$url);
    }

    public function __destruct()
    {
        setcookie('errors', json_encode($this->errors), time() + 120);
    }

}