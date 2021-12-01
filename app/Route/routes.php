<?php


use App\Controller\BlogController;
use App\Route\Route;

Route::create("/",[BlogController::class,"home"]);
Route::create("/news",[BlogController::class,"news"]);
Route::create("/news/insert",[BlogController::class,"insert"]);
Route::create("/news/{id}",[BlogController::class,"showNews"]);
