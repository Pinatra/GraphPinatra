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
        $article = collect([
          'id' => 1,
          'title' => 'ooxx',
          'city' => null,
          'is_publish' => 0,
          'read_count' => 0,
          'images' => null,
          'abstract' => null,
          'content' => null,
          'user_id' => null,
          'created_at' => null,
          'updated_at' => null,
        ]);//Article::find($args['id']);
        return $article;
      }
    ];
  }
}