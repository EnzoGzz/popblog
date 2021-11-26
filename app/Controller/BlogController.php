<?php

namespace App\Controller;

class BlogController extends Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $this->render('template', ['test' => 'John Doe']);
    }
    public function blog(string $test)
    {
        $this->render('template', ['test' => $test]);
    }
}