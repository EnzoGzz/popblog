<?php


use App\Controller\BlogController;
use App\Route\Route;

Route::create("/",[BlogController::class,"home"]);
Route::create("/post",[BlogController::class,"post"]);
Route::create("/post/insert",[BlogController::class,"insert"]);
Route::create("/post/{id}",[BlogController::class,"showPost"]);
