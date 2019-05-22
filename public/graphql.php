<?php

// PUBLIC_PATH
define('PUBLIC_PATH', __DIR__);
// BASE_PATH
define('BASE_PATH', dirname(PUBLIC_PATH));
// App directory
define('APP_DIRECTORY', BASE_PATH.'/graph_app');

// Autoload
require BASE_PATH.'/vendor/autoload.php';
// Bootstrap
require BASE_PATH.'/graph_bootstrap.php';
