<?php

namespace App\QueryFields;

use \GraphQL\Type\Definition\Type;

class ArticleQueryField
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