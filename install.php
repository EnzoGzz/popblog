<?php

use Utils\Database\DatabaseCreator;
use Utils\Database\DB;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';


if (APP_ENV === "LOCAL"){
    try{
        $con_loc = new DB("mysql:host=localhost;port=3306",DB_USERNAME,DB_PASSWORD);
        $dbc = new DatabaseCreator($con_loc);
        $dbc->makeDatabase();
        $con_loc = new DB("mysql:host=localhost;port=3306;dbname=".DB_NAME,DB_USERNAME,DB_PASSWORD);
        $dbc = new DatabaseCreator($con_loc);
        $dbc->makeUser();
        $dbc->makeContact();
        $dbc->makePost();
        $dbc->makeReview();
    }catch (Exception $e){
        echo $e->getMessage();
    }
}