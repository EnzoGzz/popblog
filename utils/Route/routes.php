<?php


use App\Controller\AdminController;
use App\Controller\ErrorController;
use App\Controller\UserController;
use Utils\ModelAdmin;
use Utils\Route\Route;



new Route("/",[UserController::class,"home"],"Home");
new Route("/blog",[UserController::class,"post"],"Blogs");
new Route("/blog/{id}",[UserController::class,"showPost"],"Blog");
new Route("/contact",[UserController::class,"contact"],"Contact");
new Route("/contact/send",[UserController::class,"contactSend"],"ContactSend",["POST"]);
new Route("/login",[UserController::class,"login"],"Login");
new Route("/login",[UserController::class,"loginPost"],"LoginPost",["POST"]);
new Route("/error404",[ErrorController::class,"error404"],"404");
new Route("/blog/{id}/comment/insert",[UserController::class,"insertComment"],"InsertComment",["POST"]);


if(ModelAdmin::isLogin()){
    new Route("/blog/insert",[AdminController::class,"insertPost"],"InsertBlog");
    new Route("/logout",[AdminController::class,"logout"],"Logout");
    new Route("/adminBlog",[AdminController::class,"post"],"AdminBlogs");
    new Route("/adminBlog/{id}",[AdminController::class,"showPost"],"AdminBlog");
    new Route("/adminBlog/{id}/delete",[AdminController::class,"deletePost"],"DeleteBlog");
    new Route("/adminBlog/{id}/comment/{idComment}/delete",[AdminController::class,"deleteComment"],"DeleteComment");
    new Route("/adminContact",[AdminController::class,"showContact"],"AdminContact");
    new Route("/adminBlog/{id}/update",[AdminController::class,"updatePost"],"UpdatePost",["POST"]);
}




