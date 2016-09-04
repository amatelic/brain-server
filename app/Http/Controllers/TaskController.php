<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;
use File;
use App\Http\Requests;
use App\Helpers\JSONAPI;
use App\Helpers\CSV;
class TaskController extends Controller
{

  function __construct()
  {
    $this->jsonapi = new JSONAPI();
  }

  /**
   * Get all users tasks
   * @param Request
   * @return Response
   */
  public function tasks(Request $request)
  {
    $day =  Carbon::now()->day;
    $token = $request->header('Api-key');
    $csv = new CSV($token);
    $reader = $csv->getExelFile();
    $obj = ['data' => []];
    foreach ($reader->toArray()[0] as $key => $read) {
      $title = $read['task'];
      unset($read['task']);
      $obj['data'][$key] = $this->createTasks($key,
        [
          'name' => $title,
          'description' => 'bla bla',
          'complited' => ($read[$day] >= 1) ? true : false,
          'monthly' => implode($read, ','),
        ]
      );
    }
    return new Response($obj);
  }
  public function createTask(Request $request)
  {
    $attributes = $request->input('data.attributes');
    $id = $request->input('data.id');
    $token = $request->header('Api-key');
    $name = $attributes['name'];
    $monthly = $attributes['monthly'];
    $content = implode(',', array_merge([$name], $monthly));
    $csv = new CSV($token);
    $csv->addTask($content);
    $task = $this->createTasks(3, $attributes);
    return new Response([
      'data' => [$task]
    ], 204);
  }

  public function updateTask(Request $request, $id)
  {
    $token = $request->header('Api-key');
    $csv = new CSV($token);
    $attributes = $request->input('data.attributes');
    $id = (int)$id + 1; //have to increment id by one
    $csv->update($id, $attributes);

    $task = $this->createTasks();
    return (new Response([
      'data' => [$task]
    ], 204));
  }
  /**
   * Method for generating ember jsonAPI response
   */
  function createTasks($index = 1, $attributes = []) {
    return  [
      'type'=> 'tasks',
      'id'=> $index,
      "attributes" => $attributes,
    ];
  }
}
