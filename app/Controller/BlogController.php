<?php

namespace App\Controller;

use App\DB\Connection;
use App\Gateway\NewsGW;

class BlogController extends Controller{

    private Connection $con;

    public function __construct()
    {
        parent::__construct();
        $this->con = new Connection("popblog",host: "localhost",username: "root", password: "toor");
    }

    public function home()
    {
        $newsGw = new NewsGW($this->con);
        $news = $newsGw->all();
        $this->render('Home', []);
    }
    public function post()
    {
        $newsGw = new NewsGW($this->con);
        $news = $newsGw->all();
        $this->render('Post', ['allNews' => $news]);
    }

    public function showPost(int $id)
    {
        $newsGw = new NewsGW($this->con);
        $news = $newsGw->find($id);
        var_dump($news);
        $this->render('Post', ['allNews' => $news]);
    }

    public function insert()
    {
        $title = $_POST['title'];
        $desc = $_POST['description'];

        $newsGw = new NewsGW($this->con);
        $newsGw->insert($title, $desc);
        $this->news();
    }
}