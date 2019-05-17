<?php

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$dotenv = Dotenv\Dotenv::create(BASE_PATH);
$dotenv->load();

\App\Models\Model::$config = [
  'driver'    => 'mysql',
  'host'      => env('DB_HOST', 'localhost'),
  'port'      => env('DB_PORT', '3306'),
  'database'  => env('DB_DATABASE', 'database'),
  'username'  => env('DB_USERNAME', 'root'),
  'password'  => env('DB_PASSWORD', 'password'),
  'charset'   => 'utf8mb4',
  'collation' => 'utf8mb4_unicode_ci',
  'prefix'    => '',
];


use \App\AppContext;
use \App\AppObjectType;
use \App\Routes;

use \GraphQL\Type\Schema;
use \GraphQL\GraphQL;
use \GraphQL\Error\FormattedError;
use \GraphQL\Error\Debug;
// Disable default PHP error reporting - we have better one for debug mode (see bellow)
ini_set('display_errors', 0);

$debug = false;
if (!empty($_GET['debug'])) {
  set_error_handler(function($severity, $message, $file, $line) use (&$phpErrors) {
    throw new ErrorException($message, 0, $severity, $file, $line);
  });
  $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
}
try {

function url(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI']
  );
}
  // Prepare context that will be available in all field resolvers (as 3rd argument):
  $appContext = new AppContext();
  $appContext->rootUrl = url();
  $appContext->request = $_REQUEST;
  // Parse incoming query and variables
  if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $raw = file_get_contents('php://input') ?: '';
    $data = json_decode($raw, true) ?: [];
  } else {
    $data = $_REQUEST;
  }
  
  $data += ['query' => null, 'variables' => null];
  
  // GraphQL schema to be passed to query executor:
  $schema = new Schema([
    'query' => new AppObjectType(Routes::export())
  ]);

  $result = GraphQL::executeQuery(
    $schema,
    $data['query'],
    null,
    $appContext,
    (array) $data['variables']
  );
  $output = $result->toArray($debug);
  $httpStatus = 200;
} catch (\Exception $error) {
  $httpStatus = 500;
  $output['errors'] = [
    FormattedError::createFromException($error, $debug)
  ];
}
header('Content-Type: application/json', true, $httpStatus);
echo json_encode($output, JSON_UNESCAPED_UNICODE);
