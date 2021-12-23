<?php

namespace App\Controller;

class ErrorController extends Controller{

    public function error404(){
        header("HTTP/1.1 404 Not Found");
        $this->render('404');
    }
}