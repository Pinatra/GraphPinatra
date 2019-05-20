<?php

namespace App\QueryFields;

use GraphQL\Type\Definition\Type;
use App\TypeRegistry;
use App\AppContext;

use App\Models\Article;

class ArticleQueryField
{
  public function export()
  {
    return [
      'type' => TypeRegistry::article(),
      'args' => [
        'id' => Type::int(),
      ],
      'resolve' => function ($root, $args, AppContext $context) {
        $article = Article::find($args['id']);
        return $article;
      }
    ];
  }
}