<?php
use Utils\Route\Router;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . "/bootstrap.php";



session_start();
Router::setup($entityManager);