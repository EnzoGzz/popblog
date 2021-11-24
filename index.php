<?php
require __DIR__ . '/vendor/autoload.php';
require './controller/Controller.php';
require './controller/blogController.php';

use Enzo\Popblog\Controller\blogController;


if(isset($_GET['p'])) {
    switch ($_GET['p']){
        case "blog":
            $c = new blogController();
            $c->blog();
            break;
        default :
            $c = new blogController();
            $c->blog();
            break;
    }
}else{
    $c = new blogController();
    $c->blog();
}