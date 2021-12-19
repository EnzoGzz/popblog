<?php


use App\Controller\AdminController;
use App\Controller\ErrorController;
use App\Controller\UserController;
use Utils\Route\Route;



Route::create("/",[UserController::class,"home"]);
Route::create("/blog",[UserController::class,"blog"]);
Route::create("/blog/{id}",[UserController::class,"showBlog"]);
Route::create("/contact",[UserController::class,"contact"]);
Route::create("/login",[UserController::class,"connexionVue"]);
Route::create("/loginP",[UserController::class,"connexion"]);
Route::create("/error404",[ErrorController::class,"error404"]);


if(isset($_SESSION["login"])){
    Route::create("/blog/{id}/comment/insert",[UserController::class,"insertComment"]);
    Route::create("/blog/insert",[AdminController::class,"insertBlog"]);
    Route::create("/logout",[AdminController::class,"logout"]);
}




