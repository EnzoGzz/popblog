<?php

namespace App\Controller;

use App\DB\Connection;
use App\Gateway\NewsGW;

class BlogController extends Controller{

    private Connection $con;

    public function __construct()
    {
        parent::__construct();
        $this->con = new Connection("popblog",host: "192.168.254.129",username: "romain", password: "romain");
    }

    public function home()
    {
        $newsGw = new NewsGW($this->con);
        $news = $newsGw->all();
        $this->render('template', ['allNews' => $news]);
    }
    public function blog(string $test)
    {
        $newsGw = new NewsGW($this->con);
        $news = $newsGw->all();
        $this->render('template', ['allNews' => $news]);
    }
}