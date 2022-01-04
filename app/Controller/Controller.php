<?php

namespace App\Controller;

use Exception;
use Twig\Environment;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Loader\FilesystemLoader;
use Utils\Database\DB;
use Utils\TwigExtension\MessageExtension;
use Utils\TwigExtension\RouteExtension;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

abstract class Controller
{
    /**
     * @var Environment
     * twig environment
     */
    private Environment $twig;
    /**
     * @var DB
     * Database connection
     */
    protected DB $con;


    public function __construct()
    {
        global $con;
        $this->con = $con;
        $loader = new FilesystemLoader(__DIR__ . '/../../view');
        $this->twig = new Environment($loader);
        $this->twigVariables();
        $this->twigExtensionLoader();

    }

    /**
     * @return void
     * Load twig variables
     */
    private function twigVariables(){
        $this->twig->addGlobal("session",$_SESSION);
        $this->twig->addGlobal("cookie",$_COOKIE);
    }

    /**
     * @return void
     * Load twig extension
     */
    private function twigExtensionLoader(){
        $this->twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
            public function load($class): ?MarkdownRuntime
            {
                if (MarkdownRuntime::class === $class) {
                    return new MarkdownRuntime(new DefaultMarkdown());
                }
                return null;
            }
        });
        $routeExtension = new RouteExtension();
        $messageExtension = new MessageExtension();
        $markdownExtension = new MarkdownExtension();
        $this->twig->addExtension($routeExtension);
        $this->twig->addExtension($messageExtension);
        $this->twig->addExtension($markdownExtension);
    }

    /**
     * @param string $name
     * @param array $args
     * @return void
     * Render view
     */
    protected function render(string $name, array $args = [])
    {
        try{
            echo $this->twig->render("$name.twig",$args);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param string $name
     * @param array $args
     * @return string
     * Get route path
     */
    protected function route(string $name, array $args = []):string
    {
        return RouteExtension::route($name,$args);
    }

    /**
     * @param string $url
     * @param string|null $messages
     * @param string|null $errors
     * @return void
     * Redirect client to route
     */
    protected function redirect(string $url, string $messages = null, string $errors = null):void
    {
        if($messages !== null)$_SESSION["messages"][] = $messages;
        if($errors !== null)$_SESSION["errors"][] = $errors;
        header("Location: ".$url);
    }

}