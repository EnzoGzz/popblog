<?php
require __DIR__ . '/vendor/autoload.php';
require './controller/Controller.php';
require './controller/BlogController.php';

use Enzo\Popblog\Controller\blogController;


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