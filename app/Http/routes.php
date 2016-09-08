<?php
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Helpers\CSV;
use App\User;
use Log;
//http://stackoverflow.com/questions/24584013/ember-cli-rundown-using-it-with-laravel-or-other-backend-frameworks
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return "view('welcome')";
});

Route::get('/tutorial', function() {
  return 'File not working';
});

Route::get('/users', 'UserController@getUser');

Route::get('/data', function () {
  $csv = new CSV('amatelic');
  $days = Carbon::now()->modify( 'next month' );
  $data = $csv->getRowLabels();
  return $days->month;
  foreach ($data as $key => $label) {
    if ($key === 0) {
      $data[$key] = array_merge([$label], range(1, $days->daysInMonth));
    } else {
      $data[$key] = array_merge([$label], array_fill(0, $days->daysInMonth , 0));
    }
  }
  return $data;
  // $csv->createCSV('bla', $data);
});


Route::get('test/{id}', 'TaskController@updateTask');

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {
    Route::post('token', 'UserController@userToken');
    Route::get('/tasks', 'TaskController@queryTask');
    Route::post('tasks', 'TaskController@createTask');
    Route::patch('tasks/{id}', 'TaskController@updateTask');
    Route::get('users/{id}', 'UserController@getUser');
    Route::post('register', 'UserController@register');
    Route::get('users/{id}/tasks', 'TaskController@tasks');
    Route::get('users/{id}/messages', 'MessageController@messages');
});

// Route::get('{ember?}', function() {
//     return View::make('ember');
// })->where('ember', '.*');
