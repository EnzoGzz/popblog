<?php
require __DIR__ . '/vendor/autoload.php';
//require './controller/Controller.php';
//require './controller/BlogController.php';
//require './config/Autoloader.php';

use Enzo\Popblog\Config\Autoloader;
use Enzo\Popblog\Controller\blogController;

Autoloader::register();

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