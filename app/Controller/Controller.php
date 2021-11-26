<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class Controller
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../view');
        $this->twig = new Environment($loader);
    }

    protected function render(string $name, array $args)
    {
        try{
            echo $this->twig->render("$name.twig",$args);
        }catch (RuntimeError $re){
            echo $re->getMessage();
        }catch (SyntaxError $se){
            echo $se->getMessage();
        }catch (LoaderError $le){
            echo $le->getMessage();
        }
    }

}