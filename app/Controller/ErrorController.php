<?php

namespace App\Controller;

class ErrorController extends Controller{

    public function error404(){
        $this->render('404');
    }
}