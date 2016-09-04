<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller
{
  public function messages(Request $request)
  {
    return (new Response([
      'data' => [
        [
          'type'=> 'message',
          'id'=> 1,
          "attributes" => [
            "title" => "This is a program",
            "text" => "text this is  just a basic working program",
            "author" => "anze matelic",
            "status" => true,
            "image" => "http://gqitalia.it/wp-content/plugins/wordpress-social-login/assets/images/default-avatar.jpg",
          ],
        ],
        [
        'type'=> 'message',
        'id'=> 2,
        "attributes" => [
          "title" => "This is just a test",
          "text" => "what the fuck is wrong with you",
          "author" => "anze matelic",
          "status" => false,
          "image" => "https://sdpp.creativeu.com/sites/all/themes/shift2014/images/default_user_thumbnail.png",
        ],
      ],
      ]
    ]));
  }
}
