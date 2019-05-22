<?php

return [
  'database' => [
    'driver'    => 'mysql',
    'host'      => env('DB_HOST', 'localhost'),
    'port'      => env('DB_PORT', '3306'),
    'database'  => env('DB_DATABASE', 'database'),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', 'password'),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
  ],
];