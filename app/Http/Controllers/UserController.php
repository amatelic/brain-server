<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
      return (new Response([
        'meta' => [
          'quote' => 'The best preparation for tomorrow is doing your best today.',
          'author' => 'H. Jackson Brown, Jr.'
        ],
        'data' => [
          'type'=> 'users',
          'id'=> 1,
          'meta' => [
            'total' => 100
          ],
          "attributes" => [
            'meta' => [
              'total' => 100
            ],
            "name" => "anze",
            "username" => "matelic",
            "email" => 'amatelic93@gmail.com',
            "image" => "https://photofeeler.s3.amazonaws.com/photos/p2i7v7t4cm7408cs.jpg",
            'plan' => 'premium',
            'auth' => 'basic',
          ],
          'meta' => [
            'total' => 100
          ],

          "relationships" => [
            "tasks" => [
              "links" => [
                "self" => "/users/1/relationships/tasks",
                "related" => "/users/1/tasks",
              ],
            ],
            "messages" => [
              "links" => [
                "self" => "/users/1/relationships/messages",
                "related" => "/users/1/messages",
              ],
            ],
            'data' => [
              ['type' => 'task', 'id' => '1'],
              ['type' => 'task', 'id' => '2'],
              ['type' => 'message', 'id' => '1'],
              ['type' => 'message', 'id' => '2'],
            ],
          ]
        ],
      ], 200));
    }
}
