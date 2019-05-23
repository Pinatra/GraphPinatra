<?php

namespace GraphApp;

use \GraphQL\Type\Definition\ObjectType;

class AppObjectType extends ObjectType
{
  public static function query($queryFields)
  {
    $resultArray = [
      'name' => 'Query',
      'fields' => [],
    ];
    foreach ($queryFields as $key => $field) {
      $resultArray['fields'][$key] = (new $field)->export();
    }
    return new self($resultArray);
  }
  public static function mutation($mutationFields)
  {
    $resultArray = [
      'name' => 'Mutation',
      'fields' => [],
    ];
    foreach ($mutationFields as $key => $field) {
      $resultArray['fields'][$key] = (new $field)->export();
    }
    return new self($resultArray);
  }
}