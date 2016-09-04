<?php

namespace App;
use Log;
use Storage;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Exception;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', "plan", "auth"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Method for creating user tasks files and directories
     * @param String
     */

    public static function createTask($email)
    {
      if (!isset($email)) {
        throw new Exception('You didn\'t include the email.');
      }

      $year = Carbon::now()->year;
      $dayInMonth = Carbon::now()->daysInMonth;
      $header = array_merge(["task"], range(1, $dayInMonth));
      $content = implode($header, ',');
      Storage::makeDirectory($email . '/' . $year);
      Storage::put($email . '/' . $year . '/' . sprintf("%02d", Carbon::now()->month) . '.csv', $content);

    }
}
