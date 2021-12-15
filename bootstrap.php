<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

$loader = require_once "vendor/autoload.php";

$paths = array(__DIR__."/app/Model/");
$isDevMode = false;
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => $DB_USERNAME,
    'password' => $DB_PASSWORD,
    'dbname'   => $DB_NAME,
);
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode,useSimpleAnnotationReader: false);
$entityManager= EntityManager::create($dbParams, $config);
