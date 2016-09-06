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
      $user = isset($user) ? $user : [];
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

    public function register(Request $request)
    {
      $email = $request->input('email');
      $user = new User([
        'name' => $request->input('name'),
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'password' => Crypt::encrypt($request->input('password')),
        'plan' => 'basic',
        'auth' => 'basic',
      ]);
      $user->save();
      User::createTask($email);
      return new Response($request, 200);
    }


    public function userToken(Request $request)
    {
      $grant_type = $request->input('grant_type');
      $email = $request->input('username');
      $password = $request->input('password');
      $user = User::where('email', $email)->get()[0];
      if ($grant_type === 'password') {
        if (isset($user)) {
          return (new Response([
            'access_token' => $user->email,
            'user_id' => $user->id,
          ], 200));
        }
      }
      $error =  array('error' => 'User dosen\'t exsist.');
      return (new Response($error, 400));
    }
}
