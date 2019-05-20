<?php

namespace App;

class TypeRegistry
{
  private static $article;

  public static function article()
  {
    return self::$article ?: (self::$article = new \App\Types\ArticleType());
  }
}