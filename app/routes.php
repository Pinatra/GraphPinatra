<?php

namespace App;

class Routes
{
  public static function export()
  {
    return [
      'echo' => \App\QueryFields\EchoQueryField::class,
    ];
  }
}