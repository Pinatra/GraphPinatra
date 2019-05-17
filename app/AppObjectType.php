<?php

namespace App;

use \GraphQL\Type\Definition\ObjectType;

class AppObjectType extends ObjectType
{
  public function __construct($queryFields)
  {
    $resultArray = [
      'name' => 'Query',
      'fields' => [],
    ];
    foreach ($queryFields as $key => $field) {
      $resultArray['fields'][$key] = (new $field)->export();
    }
    return parent::__construct($resultArray);
  }
}