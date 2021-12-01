<?php


use App\Controller\BlogController;
use App\Route\Route;

Route::create("/",[BlogController::class,"home"]);