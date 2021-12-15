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
    protected array $errors;

    public function __construct(EntityManager $em)
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../view');
        $this->twig = new Environment($loader);
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

}