<?php

namespace GraphApp;

class Routes
{
  public static function export()
  {
    return [
      'article' => \GraphApp\QueryFields\ArticleQueryField::class,
    ];
  }
}