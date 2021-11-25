<?php

namespace App\Controller;

class BlogController extends Controller{
    public function __construct()
    {
        parent::__construct();
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