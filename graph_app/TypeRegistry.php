<?php

namespace GraphApp;

class TypeRegistry
{
  private static $article;

  public static function article()
  {
    return self::$article ?: (self::$article = new \GraphApp\Types\ArticleType());
  }
}