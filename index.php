<?php

use Utils\Database\DB;
use Utils\Route\Router;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';



session_start();
global $con;
$con = new DB("mysql:host=localhost;port=3306;dbname=".DB_NAME,DB_USERNAME,DB_PASSWORD);
new Router();