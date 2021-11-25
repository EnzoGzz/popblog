<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\BlogController;

if(isset($_GET['p'])) {
    $c = new blogController();
    switch ($_GET['p']){
        case "blog":
            $c->blog();
            break;
        default :
            $c->home();
            break;
    }
}else{
    $c = new blogController();
    $c->blog();
}