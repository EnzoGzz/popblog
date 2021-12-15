<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

$loader = require_once "vendor/autoload.php";

$paths = array(__DIR__."/app/Model/");
$isDevMode = false;
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'romain',
    'password' => 'romain',
    'dbname'   => 'popblog',
);
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode,useSimpleAnnotationReader: false);
$entityManager = EntityManager::create($dbParams, $config);
