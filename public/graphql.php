<?php

// PUBLIC_PATH
define('PUBLIC_PATH', __DIR__);
// BASE_PATH
define('BASE_PATH', dirname(PUBLIC_PATH));

// Autoload
require BASE_PATH.'/vendor/autoload.php';
// Bootstrap
require BASE_PATH.'/bootstrap.php';
