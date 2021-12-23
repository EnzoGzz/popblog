<?php


use App\Controller\AdminController;
use App\Controller\ErrorController;
use App\Controller\UserController;
use Utils\Route\Route;



new Route("/",[UserController::class,"home"],"Home");
new Route("/blog",[UserController::class,"post"],"Blogs");
new Route("/blog/{id}",[UserController::class,"showPost"],"Blog");
new Route("/contact",[UserController::class,"contact"],"Contact");
new Route("/login",[UserController::class,"login"],"Login");
new Route("/login",[UserController::class,"loginPost"],"LoginPost",["POST"]);
new Route("/error404",[ErrorController::class,"error404"],"404");


if(isset($_SESSION["login"])){
    new Route("/blog/{id}/comment/insert",[UserController::class,"insertComment"],"InsertComment");
    new Route("/blog/insert",[AdminController::class,"insertPost"],"InsertBlog");
    new Route("/logout",[AdminController::class,"logout"],"Logout");
    new Route("/adminBlog",[AdminController::class,"post"],"AdminBlogs");
}




