<?php

namespace GraphApp\Models;

use Illuminate\Database\Capsule\Manager;

class DB extends Manager
{
  
  public static function enableQueryLog()
  {
    new Model;
    return parent::enableQueryLog();
  }
  public static function table($table, $connection = NULL)
  {
    new Model;
    return parent::table($table, $connection);
  }
}