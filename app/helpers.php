<?php

if (!function_exists('url')) {
  function url(){
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    );
  }
}
if (!function_exists('config')) {
  function config($name){
    $config = require BASE_PATH.'/app/config.php';
    return array_key_exists($name, $config) ? $config[$name] : null;
  }
}
if (!function_exists('cc')) {
  function cc($ha){
    echo json_encode($ha, JSON_UNESCAPED_UNICODE);
    die;
  }
}