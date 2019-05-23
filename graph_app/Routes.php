<?php

namespace GraphApp;

class Routes
{
  public static function queries()
  {
    return [
      'article' => \GraphApp\QueryFields\ArticleQueryField::class,
    ];
  }
  public static function mutations()
  {
    return [
      'article' => \GraphApp\QueryFields\ArticleQueryField::class,
    ];
  }
}