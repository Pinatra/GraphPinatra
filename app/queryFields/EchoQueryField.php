<?php

namespace App\QueryFields;

use \GraphQL\Type\Definition\Type;

class EchoQueryField
{
  public function export()
  {
    return [
      'type' => Type::string(),
      'args' => [
        'message' => Type::string(),
      ],
      'resolve' => function ($root, $args) {
        return $root['prefix'] . $args['message'];
      }
    ];
  }
}