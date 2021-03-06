<?php

use \GraphApp\AppContext;
use \GraphApp\AppObjectType;
use \GraphApp\Routes;

use \GraphQL\Type\Schema;
use \GraphQL\GraphQL;
use \GraphQL\Error\FormattedError;
use \GraphQL\Error\Debug;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler);
$whoops->register();

require APP_DIRECTORY.'/helpers.php';

$dotenv = Dotenv\Dotenv::create(BASE_PATH);
$dotenv->load();

\GraphApp\Models\Model::$config = config('database');

\GraphApp\Models\DB::enableQueryLog();

$debug = false;
if (!empty($_GET['debug'])) {
  set_error_handler(function($severity, $message, $file, $line) use (&$phpErrors) {
    throw new ErrorException($message, 0, $severity, $file, $line);
  });
  $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
}

try {
  $appContext = new AppContext();
  $appContext->rootUrl = url();
  $appContext->request = $_REQUEST;

  if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $raw = file_get_contents('php://input') ?: '';
    $data = json_decode($raw, true) ?: [];
  } else {
    $data = $_REQUEST;
  }
  
  $data += ['query' => null, 'variables' => null];

  $schema = new Schema([
    'query' => AppObjectType::query(Routes::queries()),
    'mutation' => AppObjectType::mutation(Routes::mutations()),
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

if ($debug) {
  $output['queries'] = \GraphApp\Models\DB::getQueryLog();
}

header('Content-Type: application/json', true, $httpStatus);
echo json_encode($output, JSON_UNESCAPED_UNICODE);
