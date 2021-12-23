<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once "bootstrap.php";
global $em;
return ConsoleRunner::createHelperSet($em);
