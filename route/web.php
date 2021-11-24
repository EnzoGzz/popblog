<?php

use Enzo\Popblog\Controller\BlogController;

Route::create("/",[BlogController::class,"index"]);