<?php


use App\Controller\AdminController;
use App\Controller\UserController;
use App\Route\Route;

Route::create("/",[UserController::class,"home"]);
Route::create("/post",[UserController::class,"post"]);
Route::create("/post/{id}",[UserController::class,"showPost"]);
Route::create("/post/{id}/comment/insert",[UserController::class,"insertComment"]);


Route::create("/post/insert",[AdminController::class,"insertPost"]);
Route::create("/login",[AdminController::class,"connexionVue"]);
Route::create("/loginP",[AdminController::class,"connexion"]);
