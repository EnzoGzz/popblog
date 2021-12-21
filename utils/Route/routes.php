<?php


use App\Controller\AdminController;
use App\Controller\ErrorController;
use App\Controller\UserController;
use Utils\Route\Route;



Route::create("/",[UserController::class,"home"]);
Route::create("/blog",[UserController::class,"post"]);
Route::create("/blog/{id}",[UserController::class,"showPost"]);
Route::create("/contact",[UserController::class,"contact"]);
Route::create("/login",[UserController::class,"loginVue"]);
Route::create("/loginP",[UserController::class,"login"]);
Route::create("/error404",[ErrorController::class,"error404"]);


if(isset($_SESSION["login"])){
    Route::create("/blog/{id}/comment/insert",[UserController::class,"insertComment"]);
    Route::create("/blog/insert",[AdminController::class,"insertPost"]);
    Route::create("/logout",[AdminController::class,"logout"]);
    Route::create("/adminBlog",[AdminController::class,"post"]);
}




