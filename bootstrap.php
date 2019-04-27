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

use \GraphQL\Type\Schema;
use \GraphQL\Type\Definition\Type;
use \GraphQL\Type\Definition\ObjectType;
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
    // Prepare context that will be available in all field resolvers (as 3rd argument):
    $appContext = new AppContext();
    $appContext->rootUrl = 'http://localhost:8080';
    $appContext->request = $_REQUEST;
    // Parse incoming query and variables
    if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        $raw = file_get_contents('php://input') ?: '';
        $data = json_decode($raw, true) ?: [];
    } else {
        $data = $_REQUEST;
    }
    
    $data += ['query' => null, 'variables' => null];
    if (null === $data['query']) {
        $data['query'] = '{hello}';
    }
    
    // GraphQL schema to be passed to query executor:
    $schema = new Schema([
        'query' => new ObjectType([
            'name' => 'Query',
            'fields' => [
                'clue'               => Type::string(),
                'fieldWithException' => [
                    'type' => Type::string(),
                    'resolve' => function() {
                        throw new \Exception("Exception message thrown in field resolver");
                    }
                ],
            ],
        ])
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
echo json_encode($output);
