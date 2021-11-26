<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controller\BlogController;
use App\Route\Route;
use App\Route\Setup;
Route::create("/",[BlogController::class,"home"]);
Route::create("/test/{a}/test",[BlogController::class,"blog"]);
new Setup();
//if(isset($_GET['p'])) {
//    $c = new blogController();
//    switch ($_GET['p']){
//        case "blog":
//            $c->blog();
//            break;
//        default :
//            $c->home();
//            break;
//    }
//}else{
//    $c = new blogController();
//    $c->blog();
//}