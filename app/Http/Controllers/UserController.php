<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Helpers\JSONAPI;
use Log;

class UserController extends Controller
{
    function __construct()
    {
      $this->jsonapi = new JSONAPI();
    }

    public function getUser(Request $request)
    {
      $key = $request->header('Api-key');
      $user = User::where('email', $key)->get()[0];
      $data = $this->jsonapi->createType($user->id, 'users', $user);
      $data['attributes']['image'] = "https://photofeeler.s3.amazonaws.com/photos/p2i7v7t4cm7408cs.jpg";
      return $this->jsonapi->sendResponse(
        $data, $this->jsonapi->relations($user->id),
        [
          'quote' => 'The best preparation for tomorrow is doing your best today.',
          'author' => 'H. Jackson Brown, Jr.'
        ]
      );
    }
}
