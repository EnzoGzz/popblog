<?php
namespace Enzo\Popblog\Controller;

class blogController extends Controller{
    public function __construct()
    {
        parent::__construct();
        var_dump("test");
    }

    public function home()
    {
        echo $this->twig->render('template.twig', ['test' => 'John Doe']);
    }

    public function blog()
    {
        echo $this->twig->render('template.twig', ['test' => 'John Doe']);
    }
}