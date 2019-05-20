<?php

namespace App;

class Routes
{
  public static function export()
  {
    return [
      'article' => \App\QueryFields\ArticleQueryField::class,
    ];
  }
}