<?php

namespace App\Helpers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;
use File;
use Exception;

/**
 * Basic class for working with tasks
 */
class JSONAPI
{
  public static function createType($id, $type, $attributes = [])
  {
    return  [
      "type"=> $type,
      "id"=> $id,
      "attributes" => $attributes,
    ];
  }

  public function sendResponse($data = [], $relation = [], $meta = [], $status =200)
  {
    //add relationships data
    $data['relationships'] = $relation;
    return new Response([
      "meta" => $meta,
      "data" => $data,
    ], $status);
  }

  public function relations($id)
  {
    return [
      "tasks" => [
        "links" => [
          "self" => "/users/" . $id . "/relationships/tasks",
          "related" => "/users/" . $id . "/tasks",
        ],
      ],
      "messages" => [
        "links" => [
          "self" => "/users/" . $id . "/relationships/messages",
          "related" => "/users/" . $id . "/messages",
        ],
      ],
      "data" => [
        ["type" => "task", "id" => $id],
        ["type" => "message", "id" => $id],
      ],
    ];
  }
}
