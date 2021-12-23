<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

$loader = require_once "vendor/autoload.php";
require_once "config/config.php";

$paths = array(__DIR__."/app/Model/");
$isDevMode = false;
//$dbParams = null;
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => DB_USERNAME,
    'password' => DB_PASSWORD,
    'dbname'   => DB_NAME,
);
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode,useSimpleAnnotationReader: false);
try {
    global $em;
    $em = EntityManager::create($dbParams, $config);
} catch (ORMException $e) {
    header('HTTP/1.0 505 Error Entity Manager');
}
