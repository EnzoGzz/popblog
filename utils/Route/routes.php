<?php


use App\Controller\AdminController;
use App\Controller\UserController;
use Utils\Route\Route;

Route::create("/",[UserController::class,"home"]);
Route::create("/blog",[UserController::class,"blog"]);
Route::create("/blog/{id}",[UserController::class,"showPost"]);
Route::create("/blog/{id}/comment/insert",[UserController::class,"insertComment"]);
Route::create("/contact",[UserController::class,"contact"]);


Route::create("/blog/insert",[AdminController::class,"insertPost"]);
Route::create("/login",[AdminController::class,"connexionVue"]);
Route::create("/loginP",[AdminController::class,"connexion"]);

