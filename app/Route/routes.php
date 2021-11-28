<?php


use App\Controller\BlogController;
use App\Route\Route;

Route::create("/",[BlogController::class,"home"]);
Route::create("/test/{a}/test",[BlogController::class,"blog"]);