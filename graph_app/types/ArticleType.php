<?php

namespace GraphApp\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class ArticleType extends ObjectType
{
  public function __construct()
  {
    $config = [
      'name' => 'Article',
      'description' => 'Article',
      'fields' => function() {
        return [
          'id' => Type::int(),
          'title'=> Type::string(),
          'read_count' => Type::int(),

          'fieldWithError' => [
            'type' => Type::string(),
            'resolve' => function() {
              throw new \Exception("This is error field");
            }
          ]
        ];
      },

      'resolveField' => function($value, $args, $context, ResolveInfo $info) {
        return $value[$info->fieldName];
      }
    ];
    parent::__construct($config);
  }
}